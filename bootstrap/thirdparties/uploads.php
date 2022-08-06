<?php

    class NT_Uploads {
        public static function store($name, $file) {
            $destination = __DIR__ . '/../../' . Options::get('UPLOADS_DIR') . '/' . $name;

            if(file_exists($destination)) self::erase($destination);

            move_uploaded_file($file['tmp_name'], $destination);
        }

        public static function erase($name) {
            $destination = __DIR__ . '/../../' . Options::get('UPLOADS_DIR') . '/' . $name;
            unlink($destination);
        }
    }

