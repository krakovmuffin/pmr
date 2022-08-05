<?php
    
    /**
     * This internal library is a simple wrapper over the existing $_SESSION
     * It's just a convenient and " good-looking " way to access an array
     */
    class Session {
        public function __construct() {
            session_start();
        }

        public function get($key, $default = null) {
            if(!$this->has($key)) return $default;
            return $_SESSION[$key];
        }

        public function set($key, $value) {
            $_SESSION[$key] = $value;
        }

        public function remove($key) {
            if($this->has($key))
                unset($_SESSION[$key]);
        }

        public function has($key) {
            return array_key_exists($key, $_SESSION);
        }

        public function clear() {
            session_unset();
        }

        public function destroy() {
            $this->clear();
            session_destroy();
        }
    }
