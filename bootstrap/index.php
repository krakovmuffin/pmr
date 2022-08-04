<?php
    /**
     * External Dependencies
     */
    require_once __DIR__ . '/../app/dependencies/autoload.php';

    /**
     * Local Autoloader
     */
    require __DIR__ . '/autoloader.php';

    /**
     * Global syntactic sugars
     */
    require __DIR__ . '/libs/Sugar.php';

    /**
     * Project configuration
     */
    Options::load(__DIR__ . "/../configuration/.custom.env");

    /**
     * PHP Logging
     */
    if(Options::get('MODE') === 'DEBUG') {
        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', TRUE);
        ini_set('log_errors',FALSE);
    }
    else {
        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors', 1);
        ini_set('display_errors', FALSE);
        ini_set('log_errors', TRUE);
        ini_set('error_log', '/var/log/php-fpm/error.log');
    }

    /**
     * I18n initialization
     */
    I18n::load();

    /**
     * Database connection
    */
    Database::load();

    /**
     * Retrieve extra settings from database, if enabled
     */
    if(Options::get('EXTRA_SETTINGS_ENABLED'))
        Options::load_from_database();

    /**
     * The app is just a global HTTP router
     */
    $app = new Router();

    /**
     * Mount the main "lookup table" for routes
     */
    $app->mount(new NR_Index());
