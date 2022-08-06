<?php
    /**
     * This internal library is responsible for generating HTML
     * with handy functions. It proves useful for reusability concerns,
     * such as outputing forms, inputs, templates, etc.
     */
    class Render {

        /**
         * Outputs the content of a Partial (HTML-in-PHP file)
         * and gives it parameters using a variable named $params
         *
         * @param {string} $key The plain name of the partial to retrieve, without extension
         * @param {array} $params The list of key-values to give to the partial if it's dynamic
         * @return {string} The result of calling `include partial.php` into a string
         */
        public static function partial($key, $params = []) {
            $key = strtolower($key);
            ob_start();
            include __DIR__ . "/../../app/views/partials/$key.php";
            $output = ob_get_clean();
            echo $output;
        }

        /**
         * Outputs the content of a Layout (HTML-in-PHP file)
         * and gives it parameters using a variable named $params
         *
         * @param {string} $key The plain name of the layout to retrieve, without extension
         * @param {array} $params The list of key-values to give to the layout if it's dynamic
         * @return {string} The result of calling `include layout.php` into a string
         */
        public static function layout($key, $params = []) {
            $key = strtolower($key);
            ob_start();
            include __DIR__ . "/../../app/views/layouts/$key.php";
            $output = ob_get_clean();
            echo $output;
        }

        /**
         * Outputs the content of a Component (HTML-in-PHP file)
         * and gives it parameters using a variable named $params
         *
         * @param {string} $key The plain name of the partial to retrieve, without extension
         * @param {array} $params The list of key-values to give to the partial if it's dynamic
         * @return {string} The result of calling `include partial.php` into a string
         */
        public static function component($key, $params = []) {
            $key = strtolower($key);
            ob_start();
            include __DIR__ . "/../../app/views/components/$key.php";
            $output = ob_get_clean();
            echo $output;
        }
    }
