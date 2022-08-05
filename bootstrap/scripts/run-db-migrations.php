<?php

    // Ensure the script is executed by the PHP CLI
    if(php_sapi_name() !== 'cli') {
        echo 'Error: This script must be run with the PHP CLI';
        exit();
    }

    function graceful_exit($message) {
        print($message);
        print("\n");
        print('Exited.');
        print("\n");
        exit();
    }

    require __DIR__ . '/../autoloader.php';

    // Configuration retrieval
    Options::load(__DIR__ . "/../../configuration/.custom.env");

    // Database setup
    Database::load();

    // Script entrypoint
    // -----------------
    print("Script : run-db-migrations\n");

    $is_encryption_enabled = Options::get('DB_ENCRYPTION_ENABLED');
    $dir_migrations = __DIR__ . '/../../setup/database';
    $files = scandir($dir_migrations);
    $file_prefix = $is_encryption_enabled ? 'migration-encrypted' : 'migration';

    // Retrieve all the SQL files starting with migration-xxx
    $migrations = [];
    foreach($files as $f) {
        if(!str_ends_with($f, '.sql')) continue;
        if(!str_starts_with($f, $file_prefix)) continue;
        $migrations[] = $f;
    }

    if(empty($migrations)) graceful_exit('No migration found');

    // Exclude all migrations that were run already
    foreach($migrations as $k => $m) {
        $rows = Database::query(
            'SELECT 1 FROM migrations WHERE name = :name',
            [ 'name' => $m ]
        );

        if(empty($rows)) continue;

        unset($migrations[$k]);
    }

    if(empty($migrations)) graceful_exit('No migration needs to be run');

    // Order migrations by date
    usort(
        $migrations,
        function($a, $b) use ($file_prefix) {
            $a_date = substr($a, strlen($file_prefix) + 1, 8);
            $b_date = substr($b, strlen($file_prefix) + 1, 8);

            $a_time = DateTime::createFromFormat('Ymd', $a_date);
            $b_time = DateTime::createFromFormat('Ymd', $b_date);

            if($a_time === $b_time) return 0;

            return $a_time < $b_time ? -1 : 1;
        }
    );

    // Execute every migration and insert it into database to prevent double execution
    $sql_base = 'PGPASSWORD=%s psql -v "ON_ERROR_STOP=1" -U %s -h %s -d %s < %s 2>&1';
    foreach($migrations as $m) {
        $command = sprintf(
            $sql_base,
            Options::get('DB_PASS'),
            Options::get('DB_USER'),
            Options::get('DB_HOST'),
            Options::get('DB_NAME'),
            "$dir_migrations/$m"
        );

        print("Applying migration : $m -> ");

        // Run the migration
        $output = null;
        $exit_code = null;
        exec($command, $output, $exit_code);

        if($exit_code !== 0) {
            print("failed.\n");
            print("Error : " . join(',', $output) . "\n");
            print("Script : interrupted\n");
            break;
        }

        print("applied.\n");

        // Store the migration in database
        Database::query(
            'INSERT INTO migrations ( name ) VALUES ( :name )',
            [ 'name' => $m ]
        );
    }

    print("Script : ended\n");
