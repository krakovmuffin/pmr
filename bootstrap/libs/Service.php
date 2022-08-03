<?php

    /**
     * This internal library is a base class for all the Service classes across
     * the project. Its role is to provide handy functions to attempt to cover
     * 99% of what a Service would do against the project's database.
     * In simple words, it's a generic base for running CRUD requests without efforts
     *
     * Notice : This class makes "extreme" assumptions on the database structure since
     * we believe that every scheme should follow "strict" and "battle-tested" rules.
     * That said, nothing's perfect, and this is just our very own implementation.
     *
     * To give you an example, it is assumed that every single table has a column
     * named "pk", that is a PRIMARY KEY
     *
     * As another example, it is assumed that every single data retrieval will work, because
     * it should be prepended by an existence check
     * (a.k.a a call to exists() is always made before any call to get())
     *
     */
    class Service {

        // The SQL table associated with the service
        protected $table;

        // The SQL relations associated with the service
        protected $relations;

        // The validation rules for each column in the service's SQL table
        protected $schema;

        // Whether encryption is enabled, and hence, wheter to use pgp_sym_encrypt/decrypt everywhere
        protected $is_encryption_enabled;
        protected $encryption_key;

        // The SQL tables associated with the service
        // Proves useful when one service has a different table for
        // writing and reading
        protected $table_read;
        protected $table_write;

        // Every Service should overwrite the default constructor to define
        // their own SQL affinity (associated table + relations)
        public function __construct() {
            // The SQL table associated with the current service
            $this->table = 'CHANGE ME';

            // The SQL relations associated with the current SQL table
            $this->relations = [
                'relation_name' => [

                    // The local column reference to the foreign table
                    // Unused when the type of relation is MANY-TO-MANY
                    'column' => 'fk_column',

                    // The foreign table associated with ours
                    'table' => 'CHANGE ME',

                    // The table to use for read operations if working with a view
                    'table_read' => 'CHANGE ME',

                    // The table to use for write operations if working with a view
                    'table_write' => 'CHANGE ME',

                    // The type of relation with the foreign table
                    'type' => 'ONE-TO-ONE|MANY-TO-ONEONE-TO-MANY||MANY-TO-MANY',

                    // The table of associations, when the type is MANY-TO-MANY
                    // In other words, the intermediate table in a N-N relation
                    'dictionary' => 'table de correspondance',

                    // In the dictionary, the name of the column referencing our primary key
                    'local_column' => 'A',

                    // In the dictionary, the name of the column referencing the foreign primary key
                    'foreign_column' => 'B',
                ]
            ];

            $this->schema = [];

            $this->is_encryption_enabled = Options::get('ENCRYPTION_ENABLED');
            $this->encryption_key = Options::get('ENCRYPTION_KEY');

            $this->load();
        }

        // Meant to be overriden by inheritance
        protected function load() {  }

        /**
         * Accessors
         */
        public function set_table($t) { $this->table = $t; }
        public function get_schema() { return $this->schema; }
        public function set_schema($schema) { $this->schema = $schema; }

        /**
         * Turn an array of $column => $value WHERE clauses
         * into an internal verbose representation.
         * For instance : [ 'col' => 'val' ]
         * Becomes : [ 'column' => 'col' , 'operator' => '=' , 'value' => 'val' ]
         */
        protected function _normalize_conditions($conditions) {
            if(empty($conditions)) return [];
            if(Arrays::is_multi_array($conditions)) return $conditions;

            $new_conditions = [];
            foreach($conditions as $k => $v) {
                $new_conditions[] = [
                    'column' => $k,
                    'operator' => '=',
                    'value' => $v
                ];
            }

            return $new_conditions;
        }

        /**
         * Apply extra treatment on user-supplied values before inserting/updating rows
         * At the moment, that is used only to turn booleans into 1s and 0s
         */
        protected function _normalize_payload($payload) {
            if ( empty($payload) ) return [];

            $new_payload = [];

            foreach($payload as $k => $v) {
                $new_value = $v;

                if ( $v === false )
                    $new_value = 0;

                if ( $v === true )
                    $new_value = 1;

                $new_payload[$k] = $new_value;
            }

            return $new_payload;
        }

        /**
         * Generates a WHERE string given a set of conditions
         * Note of implementation : All the conditions are joined by the -AND clause
         *
         * @param {array<array>} $conditions A list of conditions, such that
         *                       -> column : The name of the column to test
         *                       -> operator : The operator to use for the test, = by default
         *                       -> value : The expected value. Using [XXX] will escape XXX
         *                       -> alias : What to rename the prepared :parameter if needed
         * @param {boolean} $is_strict Whether to use AND or OR for joining conditions
         * @param {boolean} $is_decrypted Whether to wrap every column with pgp_sym_decrypt
         *
         *  @return {string} The full WHERE clause, without the -WHERE keyword
         */
        protected function _build_where_str($conditions, $is_strict = true) {
            if(empty($conditions)) return;

            $base = ' WHERE  ';
            $conditions_strs = [];

            $has_to_be_decrypted = $this->is_encryption_enabled === true ? true : false;

            // If conditions are not expressed as an array of arrays, normalize them
            // [ $key => $value ] becomes the format described in the documentation
            if(!Arrays::is_multi_array($conditions))
                $conditions = $this->_normalize_conditions($conditions);

            // Process the conditions
            foreach($conditions as $c) {
                if ( $has_to_be_decrypted )
                    $c_str = $this->_build_decrypted_column_str($c['column']);
                else
                    $c_str = $c['column'];
                
                $column = empty($c['alias']) ? $c['column'] : $c['alias'];

                $c_str .= ' ';

                if(!empty($c['operator']))
                    $c_str .= $c['operator'];
                else
                    $c_str .= '=';

                $c_str .= ' ';

                // Value = Array
                if(is_array($c['value'])) {
                    $c_str .= '(';

                    $indexed_placeholders = [];
                    foreach($c['value'] as $idx => $v)
                        $indexed_placeholders[] = ':' . $column . '_' .$idx;
                    $c_str .= join(', ', $indexed_placeholders);

                    $c_str .= ')';
                }
                // Value = [SQL_STUFF]
                else if(str_starts_with($c['value'], '['))
                    $c_str .= str_replace([ '[' , ']' ], '', $c['value']);
                // Value = Literal
                else {
                    $c_str .= ' :' ;

                    // table.column
                    if(str_contains($column, '.'))
                        $c_str .= str_replace('.', '_', $column);
                    // column
                    else
                        $c_str .= $column;
                }

                $conditions_strs[] = $c_str;
            }

            $conditions_joiner = $is_strict ? ' AND ' : ' OR ';
            $where_str = $base . join($conditions_joiner, $conditions_strs);
            return $where_str;
        }

        /**
         * Generates a SET string given a set of key-values
         *
         * @param {array<array>} $conditions A list of conditions, such that
         *                       -> column : The name of the column to test
         *                       -> operator : The operator to use for the test, = by default
         *                       -> value : The expected value. Using [XXX] will escape XXX
         *                       -> alias : What to rename the prepared :parameter if needed
         *
         *  @return {string} The full WHERE clause, without the -WHERE keyword
         */
        protected function _build_set_str($fields, $placeholder_prefix = null) {
            $base = '  ';

            $fields_strs = [];

            // Conditions described as an array of key-values
            foreach($fields as $k => $v) {
                $f_str = $k;
                $f_str .= ' ';
                $f_str .= '=';
                $f_str .= ' ';

                $placeholder = null;

                // Value = [SQL_STUFF]
                if(str_starts_with($v, '['))
                    $placeholder = str_replace([ '[' , ']' ], '', $v);
                // Value = Literal
                else {
                    $placeholder .= ' :' ;

                    if ( !empty($placeholder_prefix) )
                        $k = $placeholder_prefix . $k;

                    // table.column
                    if( str_contains($k, '.') )
                        $placeholder .= str_replace('.', '_', $k);
                    else
                        $placeholder .= $k;
                }

                // Intentional SQL cast to text
                if ( $this->is_encryption_enabled )
                    $f_str .= $this->_build_encrypted_column_str("$placeholder::text");
                else
                    $f_str .= $placeholder;

                $fields_strs[] = $f_str;
            }

            $set_str = $base . join(',', $fields_strs);
            return $set_str;
        }

        protected function _build_page_str() {
            return "LIMIT :per_page OFFSET :page_shift";
        }

        protected function _build_page_payload($params) {
            $per_page = $params['per_page'];
            $page_shift = $per_page * ($params['page'] - 1);

            return [ 'per_page' => $per_page , 'page_shift' => $page_shift ];
        }

        /**
         * Generates a WHERE "payload" given a set of conditions with their values
         * Payload is just an obnovious way to call an associative array of key-values
         * This function just takes care of escaping SQL when needed, or applying specific treatments
         *
         * @param {array<array>} $conditions See _build_where_str
         * @return {array} The list of key-values to further fill the prepared statement in the WHERE clause
         */
        protected function _build_query_payload($conditions, $placeholder_prefix = null) {
            if(empty($conditions)) return [];

            $payload = [];

            // If conditions are not expressed as an array of arrays, normalize them
            // [ $key => $value ] becomes the format described in the documentation
            if(!Arrays::is_multi_array($conditions))
                $conditions = $this->_normalize_conditions($conditions);

            foreach($conditions as $c) {
                // Value = [SQL_STUFF]
                if(is_string($c['value']) && str_starts_with($c['value'], '['))
                    continue;

                $column = !empty($c['alias']) ? $c['alias'] : $c['column'];

                if(!empty($placeholder_prefix))
                    $column = $placeholder_prefix . $column;

                // Value = Array
                if(is_array($c['value'])) {
                    foreach($c['value'] as $idx => $v)
                        $payload['' . $column . '_' . $idx] = $v;

                    continue;
                }

                // Value = Literal
                if(str_contains($column, '.'))
                    $payload[str_replace('.', '_', $column)] = $c['value'];
                else
                    $payload[$column] = $c['value'];
            }

            $payload = $this->_normalize_payload($payload);

            return $payload;
        }

        /**
         * Generates an ORDER BY clause
         *
         * @param {array} $params A list of column => order (ASC / DESC)
         * @return {string} A full ORDER BY clause
         */

        protected function _build_order_str($params) {
            $order = $params['order'] ?? [];

            if(empty($order)) return;

            $base_str = "ORDER BY ";
            $order_strs = [];

            foreach($order as $k => $v)
                $order_strs[] = "$k $v";

            return $base_str . join(', ' , $order_strs);
        }

        /**
         * Handy method to determine which table to use for reading / writing in the service
         * 99% of the time, that will pick the only table associated with the current service
         * Yet sometimes, a Service might use a table / view for reading, and another for writing,
         * and this is when that method proves useful
         *
         * @param {string} $operation Either 'read' or 'write'
         * @return {string} The table to run SQL against
         */
        private function _determine_table_for($operation) {
            if(!empty($this->table))
                return $this->table;

            if($operation === 'read')
                return $this->table_read;

            if($operation === 'write')
                return $this->table_write;
        }

        protected function _build_encrypted_column_str($field) {
            $key = $this->encryption_key;
            return "pgp_sym_encrypt($field, '$key')";
        }

        protected function _build_encrypted_placeholder_str($field) {
            $key = $this->encryption_key;
            return "pgp_sym_encrypt(:$field, '$key')";
        }

        protected function _build_decrypted_column_str($field) {
            $key = $this->encryption_key;
            return "pgp_sym_decrypt($field, '$key')";
        }

        protected function _build_decrypted_placeholder_str($field) {
            $key = $this->encryption_key;
            return "pgp_sym_decrypt(:$field, '$key')";
        }

        /**
         * Query the table associated with the current Service to retrieve all the columns
         * and return a comma-separated list of these, with proper calls to pgp_sym_decrypt
         * That is supposed to produce a perfect replacement for the native '*' of SQL, except
         * that it takes care of decrypting data
         *
         * @return {string} A comma-separated list of columns wrapped inside a pgp_sym_decrypt()
         */
        protected function _build_decrypted_table_columns_str($table = null, $prefix = null) {
            $encryption_key = $this->encryption_key;

            if ( empty($table) )
                $table = $this->_determine_table_for('read');

            $rows = Database::query(
                                    "SELECT column_name
                                     FROM information_schema.columns
                                     WHERE table_name = :table",
                                    [ 'table' => $table ]
            );
            $columns = array_column($rows, 'column_name');

            $str = join(
                ', ',
                array_map(
                    function($cn) use ($encryption_key, $prefix) {
                        
                        return empty($prefix) 
                            ? "pgp_sym_decrypt($cn, '$encryption_key') AS $cn"
                            : "pgp_sym_decrypt($prefix.$cn, '$encryption_key') AS $cn";
                    },
                    $columns
                )
            );

            return $str;
        }

        /**
         * Given an ID, determines whether an entry exists within the service's table
         *
         * @param {string} $id The value to look for in the "pk" column of the service's table
         * @return {boolean} true if found, false otherwise
         */
        public function exists($id) {
            $table = $this->_determine_table_for('read');

            $column = 'pk';
            if ( $this->is_encryption_enabled )
                $column = $this->_build_decrypted_column_str($column);

            $rows = Database::query(
                "SELECT 1 FROM $table WHERE $column = :id",
                [ 'id' => $id ]
            );

            return empty($rows) ? false : true;
        }

        /**
         * Given a set of conditions, determines whether an entry exists within the service's table
         *
         * @param {array<array>} $conditions See _build_where_str
         * @return {boolean} true if found, false otherwise
         */
        public function exists_one($conditions) {
            $table = $this->_determine_table_for('read');

            $where_str = $this->_build_where_str($conditions);

            $where_payload = $this->_build_query_payload($conditions);

            $rows = Database::query(
                "SELECT 1 FROM $table $where_str LIMIT 1",
                $where_payload
            );

            return empty($rows) ? false : true;
        }

        /**
         * Given an ID, retrieves the associated entry within the service's table
         *
         * @param {string} $id The value to look for in the "pk" column of the service's table
         * @return {array} The found entry, as an associative array
         */
        public function get($id) {
            $table = $this->_determine_table_for('read');

            $column = 'pk';
            if ( $this->is_encryption_enabled )
                $column = $this->_build_decrypted_column_str($column);

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "SELECT $returned_columns FROM $table WHERE $column = :id",
                [ 'id' => $id ]
            );

            return $rows[0];
        }

        public function get_many($page_parameters) {
            $table = $this->_determine_table_for('read');

            $per_page = $page_parameters['per_page'];
            $page_shift = $per_page * ($page_parameters['page'] - 1);

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "SELECT $returned_columns FROM $table LIMIT :per_page OFFSET :page_shift",
                [ 'per_page' => $per_page,  'page_shift' => $page_shift ]
            );

            return $rows;
        }

        /**
         * Retrieves all the records stored within the service's table
         *
         * @return {array<array>} The list of records coming stored in the service's table
         */
        public function get_all() {
            $table = $this->_determine_table_for('read');

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "SELECT $returned_columns FROM $table"
            );

            return $rows;
        }

        /**
         * Counts and returns the number of records stored in the service's table
         *
         * @return {int} The number of records stored in the service's table
         */
        public function get_count() {
            $table = $this->_determine_table_for('read');

            $rows = Database::query(
                "SELECT COUNT(*) AS total FROM $table"
            );

            return (int)$rows[0]['total'];
        }

        /**
         * Given a set of conditions, retrieves the first matching record within the service's table
         *
         * @param {array<array>} $conditions See _build_where_str
         *
         * @return {array} The first matched record
         */
        public function find_one($conditions) {
            $table = $this->_determine_table_for('read');

            $where_str = $this->_build_where_str($conditions);

            $where_payload = $this->_build_query_payload($conditions);

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "SELECT $returned_columns FROM $table $where_str LIMIT 1",
                $where_payload
            );

            return $rows[0];
        }

        /**
         * Given a set of conditions, and pagination parameters, retrieves a list of matching records
         * within the service's table
         *
         * @param {array<array>} $conditions See _build_where_str
         * @param {array} $page_parameters An associative array such that
         *                                 -> {int} per_page : The number of records per page
         *                                 -> {int} page : The 1-indexed page of records to retrieve
         *                                 -> {boolean} strict_search : Whether search should be AND- or OR-joined
         *                                 -> {array} order : The column to use for ordering the rows (C => O)
         * @param {boolean} $is_strict Whether to use AND or OR for joining conditions
         *
         * @return {array<array>} The paginated list of matching rows that were found and retrieved
         */
        public function find_many($conditions, $page_parameters) {
            $table = $this->_determine_table_for('read');

            $where_str = $this->_build_where_str($conditions, $page_parameters['strict_search'] ?? true);

            $where_payload = $this->_build_query_payload($conditions);

            $page_str = $this->_build_page_str($page_parameters);
            $page_payload = $this->_build_page_payload($page_parameters);

            $order_str = $this->_build_order_str($page_parameters);

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "SELECT $returned_columns FROM $table $where_str $order_str $page_str",
                array_merge($where_payload, $page_payload)
            );

            return $rows;
        }

        /**
         * Given a set of conditions, returns the total number of rows that matched
         *
         * @param {array<array>} $conditions See _build_where_str
         * @return {int} The number of matched rows
         */
        public function find_count($conditions, $page_parameters = []) {
            $table = $this->_determine_table_for('read');

            $where_str = $this->_build_where_str($conditions, $page_parameters['strict_search'] ?? true);

            $where_payload = $this->_build_query_payload($conditions);

            $rows = Database::query(
                "SELECT COUNT(*) AS total FROM $table $where_str",
                $where_payload
            );

            return (int)$rows[0]['total'];
        }

        /**
         * Given a set of conditions, returns all the matching entries within the service's table
         *
         * @param {array<array>} $conditions See _build_where_str
         * @return {array<array>} The list of found records, an empty array if no match
         */
        public function find_all($conditions, $page_parameters = []) {
            $table = $this->_determine_table_for('read');

                $where_str = $this->_build_where_str($conditions, $page_parameters['strict_search'] ?? true);

            $where_payload = $this->_build_query_payload($conditions);

            $order_str = $this->_build_order_str($page_parameters);

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "SELECT $returned_columns FROM $table $where_str $order_str",
                $where_payload
            );

            return $rows;
        }

        /**
         * Inserts a new record within the service's table and returns it
         *
         * @param {array} $payload The list of key-values defining the record
         * @return {array} The inserted record, post-insertion
         */
        public function create($payload) {
            $table = $this->_determine_table_for('write');

            $payload = $this->_normalize_payload($payload);
            $fields = array_keys($payload);

            $parenthesis_str = join(', ', $fields);
            $values_str = join(
                ', ',
                array_map(
                    function ($field) {
                        // Database encryption enabled
                        if ( $this->is_encryption_enabled )
                            return $this->_build_encrypted_placeholder_str($field);
                        // Normal query
                        else
                            return ':' . $field;
                    },
                    $fields
                )
            );

            if ( $this->is_encryption_enabled ) {
                $parenthesis_str .= ' , pk' ;
                $values_str .= ' , ' . $this->_build_encrypted_placeholder_str('pk');
                $payload = array_merge($payload , [ 'pk' => UUID::v5() ]);
                $returned_columns = $this->_build_decrypted_table_columns_str();
            }
            else
                $returned_columns = '*';

            $rows = Database::query(
                "INSERT INTO $table
                 ($parenthesis_str)
                 VALUES
                 ($values_str)
                 RETURNING $returned_columns",
                $payload
            );

            return $rows[0];
        }

        /**
         * Given an ID and a set of new values, updates an entry within the service's table
         *
         * @param {string} $id The value to look for in the "pk" column of the service's table
         * @param {array} $payload The new key-values to set for the identified entry
         * @return {array} The updated entry, as an associative array
         */
        public function update($id, $payload) {
            $table = $this->_determine_table_for('write');

            $primary_key = 'pk';
            if ( $this->is_encryption_enabled )
                $primary_key = $this->_build_decrypted_column_str($primary_key);

            $set_str = $this->_build_set_str($payload);

            $set_payload = $this->_build_query_payload($payload);

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();


            $rows = Database::query(
                "UPDATE $table
                 SET $set_str
                 WHERE $primary_key = :id
                 RETURNING $returned_columns",
                 array_merge(
                     [ 'id' => $id ],
                     $set_payload
                 )
            );

            return $rows[0];
        }

        /**
         * Given an ID, deletes an entry within the service's table
         *
         * @param {string} $id The value to look for in the "pk" column of the service's table
         */
        public function delete($id) {
            $table = $this->_determine_table_for('write');

            $column = 'pk';
            if ( $this->is_encryption_enabled )
                $column = $this->_build_decrypted_column_str($column);

            Database::query(
                "DELETE FROM $table WHERE $column = :id",
                [ 'id' => $id ]
            );
        }

        // Update one or many using conditions
        public function find_and_update($conditions, $payload) {
            $table = $this->_determine_table_for('write');

            $where_str = $this->_build_where_str($conditions);

            $where_payload = $this->_build_query_payload($conditions);

            $set_str = $this->_build_set_str($payload, 'new_');

            $set_payload = $this->_build_query_payload($payload, 'new_');

            $returned_columns = '*';
            if ( $this->is_encryption_enabled )
                $returned_columns = $this->_build_decrypted_table_columns_str();

            $rows = Database::query(
                "UPDATE $table
                 SET $set_str
                 $where_str
                 RETURNING $returned_columns",
                 array_merge(
                     $where_payload,
                     $set_payload
                 )
            );

            return $rows;
        }

        // Delete one or many using conditions
        public function find_and_delete($conditions) {
            $table = $this->_determine_table_for('write');

            $where_str = $this->_build_where_str($conditions);

            $where_payload = $this->_build_query_payload($conditions);

            Database::query(
                "DELETE FROM $table $where_str",
                $where_payload
            );
        }

        /**
         * Populates a relational field within a given entry
         * Assumption made : Pagination isn't supposed to be made here as listing UIs should query
         *                   the children elements, and not try to load the main, and populate it
         *
         * @param {&array} $object The entry to populate the relation of, in place
         * @param {string} $field The name of the relation to populate
         * @param {array} $conditions See _build_where_str, only applicable in MANY-TO-ONE/ONE-TO-MANY relationship
         * @param {array} $page_parameters Only applicable in MANY-TO-ONE/ONE-TO-MANY to apply conditions on OR / AND base
         * @param {array} $conditions See _build_where_str
         */
        public function populate(&$object, $field, $conditions = [], $page_parameters = []) {
            $relation = $this->relations[$field];

            $foreign_table = $relation['table'];

            switch($relation['type']) {

                // 1-1
                case 'ONE-TO-ONE':
                    // Case when developer specified both local and foreign column for join
                    if(empty($relation['column'])) {
                        $local_column = $relation['local_column'];
                        $join_column = $relation['foreign_column'];
                    }
                    // Case when local column is known (pk) and foreign column only is given
                    else {
                        $local_column = 'pk';
                        $join_column = $relation['column'];
                    }

                    // Build conditions
                    $all_conditions = [
                        [
                            "column" => $join_column,
                            "operator" => "=",
                            "value" => $object[$local_column]
                        ]
                    ];

                    $where_str = $this->_build_where_str($all_conditions, $page_parameters['strict_search'] ?? true);

                    $where_payload = $this->_build_query_payload($all_conditions);

                    $returned_columns = '*';
                    if ( $this->is_encryption_enabled )
                        $returned_columns = $this->_build_decrypted_table_columns_str($foreign_table);

                    $rows = Database::query(
                        "SELECT $returned_columns FROM $foreign_table $where_str LIMIT 1",
                        $where_payload
                    );

                    $object[$field] = empty($rows) ? [] : $rows[0];
                break;

                // 1-N
                case 'ONE-TO-MANY':
                case 'MANY-TO-ONE':
                    // Case when developer specified both local and foreign column for join
                    if(empty($relation['column'])) {
                        $local_column = $relation['local_column'];
                        $join_column = $relation['foreign_column'];
                    }
                    // Case when local column is known (pk) and foreign column only is given
                    else {
                        $local_column = 'pk';
                        $join_column = $relation['column'];
                    }

                    // Build conditions
                    $all_conditions = [
                        [
                            "column" => $join_column,
                            "operator" => "=",
                            "value" => $object[$local_column]
                        ]
                    ];
                    $all_conditions = array_merge($all_conditions, $this->_normalize_conditions($conditions));

                    $where_str = $this->_build_where_str($all_conditions, $page_parameters['strict_search'] ?? true);

                    $where_payload = $this->_build_query_payload($all_conditions);

                    $returned_columns = '*';
                    if ( $this->is_encryption_enabled )
                        $returned_columns = $this->_build_decrypted_table_columns_str($foreign_table);

                    $rows = Database::query(
                        "SELECT $returned_columns FROM $foreign_table $where_str ",
                        $where_payload
                    );

                    $object[$field] = $rows;
                break;

                // N-N
                case 'MANY-TO-MANY':
                    $dictionary_table = $relation['dictionary'];
                    $local_column = $relation['local_column'];
                    $foreign_column = $relation['foreign_column'];

                    $all_conditions = [
                        [
                            "column" => "d.$local_column",
                            "operator" => "=",
                            "value" => $object['pk']
                        ]
                    ];

                    $where_str = $this->_build_where_str($all_conditions);

                    $where_payload = $this->_build_query_payload($all_conditions);

                    $returned_columns = 'f.*';
                    if ( $this->is_encryption_enabled )
                        $returned_columns = $this->_build_decrypted_table_columns_str($foreign_table, 'f');

                    $encryption_key = $this->encryption_key;
                    $rows = Database::query(
                        "SELECT $returned_columns
                         FROM $dictionary_table AS d" 
                        .
                        (
                            $this->is_encryption_enabled
                            ? " INNER JOIN $foreign_table AS f ON pgp_sym_decrypt(f.pk, '$encryption_key') = pgp_sym_decrypt(d.$foreign_column, '$encryption_key')"
                            : " INNER JOIN $foreign_table AS f ON f.pk = d.$foreign_column"
                        )
                        .
                        " $where_str",
                        $where_payload
                    );
                    $object[$field] = $rows;
                break;

                default: break;
            }
        }

        /**
         * Populates a relational field for every entry of a given list
         * This is just a loop wrapper over populate
         *
         * @param {&array<array>} $objects The entries to populate the relation of, in place
         * @param {string} $field The name of the relation to populate
         * @param {array} $conditions See _build_where_str
         */
        public function populate_many(&$objects, $field, $conditions = [], $page_parameters = []) {
            foreach($objects as &$object)
                $this->populate($object, $field, $conditions, $page_parameters);
        }
    }
