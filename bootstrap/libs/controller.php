<?php

    /**
     * Base class inherited by every Controller
     *
     * So far, its only role is to hold a list of Services and Adapters
     * identifier by an arbitrary name
     */
    class Controller {
        protected $adapters;
        protected $services;
        protected $thirdparties;

        public function __construct() {
            $this->adapters = [];
            $this->services = [];
            $this->thirdparties = [];

            $this->load();
        }

        /**
         * Meant to be overriden
         */
        protected function load() {}

        /**
         * Adds an instance of Adapter to the internal list
         *
         * @param {string} $name : The name associated with the Adapter instance
         * @param {any} $instance : The instance of the Adapter to store
         */
        public function register_adapter($name, $instance) {
            $this->adapters[$name] = $instance;
        }

        /**
         * Adds an instance of Service to the internal list
         *
         * @param {string} $name : The name associated with the Service instance
         * @param {any} $instance : The instance of the Service to store
         */
        public function register_service($name, $instance) {
            $this->services[$name] = $instance;
        }

        /**
         * Adds an instance of Thirdparty to the internal list
         *
         * @param {string} $name : The name associated with the Thirdparty instance
         * @param {any} $instance : The instance of the Thirdparty to store
         */
        public function register_thirdparty($name, $instance) {
            $this->thirdparties[$name] = $instance;
        }

        /**
         * Turns GET parameters into SQL conditions
         *
         * @param {array} $schema : The schema to look for ($f => $operator)
         * @param {array} $params : The GET parameters ($k => $v)
         * @return {array<array>} : A list of SQL conditions @see _build_where_str
         */
        public function generate_sql_filters($schema, $params) {
            $filters = [];

            foreach($params as $k => $v) {
                if(empty($schema[$k])) continue;
                if(empty($v)) continue;

                $filters[] = [
                    'column' => $k,
                    'operator' => $schema[$k],
                    'value' => in_array($schema[$k], ['LIKE', 'ILIKE']) ? "%$v%" : $v
                ];
            }

            return $filters;
        }

        /**
         * Turns GET parameters into a querystring
         *
         * @param {array} $schema : The schema to look for ($f => $operator)
         * @param {array} $params : The GET parameters ($k => $v)
         * @return {array<array>} : A GET querystring
         * TODO : urlencode ?
         */
        public function generate_str_filters($schema, $params) {
            $filters = [];

            foreach($params as $k => $v) {
                if(empty($schema[$k])) continue;

                $filters[] = "$k=$v";
            }

            return join('&', $filters);
        }
    }
