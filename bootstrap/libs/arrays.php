<?php
    class Arrays {

        /**
         * Retrieve an array's value via dot-notation path
         * For instance : $array['business.address.zip']
         * Becomes : $array['business']['address']['zip']
         */
        public static function get($arr, $path, $default = null) {
            if(empty($arr)) return $default;
            if(empty($path)) return $default;

            $parts = explode('.', $path, 2);
            $first_part = $parts[0];
            $rest = $parts[1] ?? null;

            if(!empty($arr[$first_part]) && empty($rest))
                return $arr[$first_part];

            if(empty($arr[$first_part]) && empty($rest))
                return $default;

            return self::get($arr[$first_part], $rest);
        }

        /**
         * Run a filter function against each element of an array and returns
         * whether at least one element returns true through the filter function
         */
        public static function any($arr, $fn) {
            if(empty($arr)) return false;
            if(empty($fn)) return false;

            foreach($arr as $e) {
                $result = $fn($e);

                if($result === true) return true;
            }

            return false;
        }

        /**
         * Run a filter function against each element of an array and returns
         * whether all the elements satisfy the filter or not
         */
        public static function all($arr, $fn) {
            if(empty($fn)) return true;
            if(empty($arr)) return false;

            foreach($arr as $e) {
                $result = $fn($e);

                if($result === false) return false;
            }

            return true;
        }

        /**
         * Return the first element of an array, that satisfies a filter function
         */
        public static function find($arr, $fn, $default = null) {
            if(empty($arr)) return $default;
            if(empty($fn)) return $default;

            foreach($arr as $e) {
                $result = $fn($e);

                if($result === true) return $e;
            }

            return $default;
        }

        /**
         * Determine whether the given array is a simple key => value table
         * or an array of arrays, nothing fancy
         */
        public static function is_multi_array($arr) {
            $keys = array_keys($arr);

            $first_key = $keys[0];
            $first_element = $arr[$first_key];

            if(is_array($first_element))
                return true;

            return false;
        }

        public static function is_associative($arr) {
            if (array() === $arr) return false;
            return array_keys($arr) !== range(0, count($arr) - 1);
        }

        public static function whitelist($arr, $allowed) {
            if(empty($arr)) return [];
            if(empty($allowed)) return [];

            if ( self::is_associative($arr) )
                return array_intersect_key($arr, array_flip($allowed));

            return array_values(array_intersect_key($arr, $allowed));
        }

        public static function blacklist($arr, $excluded) {
            if(empty($arr)) return [];
            if(empty($excluded)) return $arr;

            if ( self::is_associative($arr) )
                return array_diff_key($arr, array_flip($excluded));

            return array_values(array_diff_key($arr, $excluded));
        }

    }
