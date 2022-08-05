<?php

    /**
     * An Adapter is responsible for altering an object or an array of objects
     * Its role is to obfuscate the database scheme, or at least flatten / beautify it
     * for the end user.
     */
    class Adapter {

        // List of aliases ( a -> b )
        protected $mappers;

        // List of exclusions ( a -> a disappears )
        protected $excluders;

        // List of dynamic values ( a -> function of the object that's got a )
        protected $computers;

        // Each of these is organized by namespace
        // In other words, a name is associated with every mapper / excluder / computer

        // Constructor - Initialize all the internal modifiers
        public function __construct() { 
            $this->mappers = [];
            $this->excluders = [];
            $this->computers = [];
        }

        /**
         * Applies mappers, excluders, and computers to an object
         * Modifies the object directly by reference
         *
         * @param {array} $object The object to edit
         * @param {string} $key The name of the set of rules to apply
         */
        public function apply_one(&$object, $key = 'default') {
            if (empty($object)) return;

            // Alias
            if(isset($this->mappers[$key])) {
                foreach($this->mappers[$key] as $property => $alias) {
                    $object[$alias] = $object[$property];
                    unset($object[$property]);
                }
            }

            // Compute
            if(isset($this->computers[$key])) {
                foreach($this->computers[$key] as $property => $fn) 
                    $object[$property] = $fn($object);
            }

            // Exclude
            if(isset($this->excluders[$key]))
                $object = array_diff_key($object, array_flip($this->excluders[$key]));
        }

        /**
         * Calls apply_one for every element given
         *
         * @param {array<array>} $objects An array of associative arrays
         * @param {string} $key The name of the set of rules to apply
         */
        public function apply_many(&$objects, $key = 'default') {
            foreach($objects as &$object)
                $this->apply_one($object, $key);
        }

        // Accessors
        public function set_mapper($key, $mapper) {
            $this->mappers[$key] = $mapper;
        }
    }
