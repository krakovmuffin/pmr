<?php

    function autoloader($classname) {
        $parts = explode('_', $classname);

        // Case when : Class
        if(count($parts) === 1) {
            require __DIR__ . '/libs/' . strtolower($parts[0]) . '.php';
            return;
        }

        // Case when : Abreviation_Class
        if(count($parts) === 2) {
            // NX_YYY -> /bootstrap
            if ( str_starts_with($parts[0] , 'N' ) ) {
                $base_dir = '/bootstrap';
                $parts[0] = substr($parts[0], 1);
            } 
            // X_YYY -> /app
            else 
                $base_dir = '/app';

            $mapping = [
                // Predefined directories
                'A' => 'adapters',
                'C' => 'controllers',
                'J' => 'jobs',
                'M' => 'middlewares',
                'R' => 'routes',
                'S' => 'services',
                'T' => 'thirdparties',
            ];

            $subfolder = $mapping[$parts[0]];

            require 
                __DIR__     . 
                '/..'       . 
                $base_dir   . 
                '/'         .
                $subfolder  .
                '/'         .
                strtolower($parts[1]) . '.php';

            return;
        }
    }

    spl_autoload_register('autoloader');
