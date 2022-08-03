<?php

    function vd(...$mixed) { var_dump(...$mixed); } 
    
    /**
     * Practical aliases
     * HC -> HTML Component -> Render::component
     * HP -> HTML Partial -> Render::partial
     * HL -> HTML Layout -> Render::layout
     */
    function HC($key, $params = []) {
        Render::component($key, $params);
    }

    function HP($key, $params = []) {
        Render::partial($key, $params);
    }

    function HL($key, $params = []) {
        Render::layout($key, $params);
    }

    /**
     * Practical path generators
     */
    function front_path($path) {
        return Options::get('ROOT_FRONT') . $path;
    }

    function front_upload_path($path) {
        return Options::get('ROOT_ASSETS') . '/' . Options::get('UPLOADS_DIR') . '/' . $path ;
    }

    function front_asset_path($path) {
        return Options::get('ROOT_ASSETS') . '/' . $path . '?v=' . Options::get('ASSETS_VERSION');
    }

    /**
     * Output sanitization
     *
     * @param {string} $str The string to sanitize before output
     * @return {string} The sanitized string
     */
    function sanitize_before_output($str) {
        if(empty($str)) return;
        return htmlentities($str, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Simple and handy alias for I18n::translate, with substitution support
     *
     * @param {string} $key The string to translate
     * @param {array} $params The list of parameters to substitue in the string, if needed
     * @return {string} The translated $key, substituted with $params if needed.
     */
    function __($key, $params = []) {
        if(empty($params))
            return I18n::translate($key);

        return sprintf(I18n::translate($key), ...$params);
    }

    /**
     * Simple and handy alias for sanitize_before_output()
     */
    function _e($str) {
        return sanitize_before_output($str);
    }

    /**
     * Handy ways to create an instance of a [native] middleware by using just its name
     */
    function native_mdw($name, $parameters = []) {
        $name = ucfirst($name);
        $class = "NM_$name";
        $instance = new $class($parameters);
        return $instance;
    }

    function mdw($name, $parameters = []) {
        $name = ucfirst($name);
        $class = "M_$name";
        $instance = new $class($parameters);
        return $instance;
    }
