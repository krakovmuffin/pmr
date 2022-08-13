<?php

    class S_Dictionaries extends Service {
        public function all($table) {
            $this->table = 'dictionary_' . $table;
            return parent::get_all();
        }
    }
