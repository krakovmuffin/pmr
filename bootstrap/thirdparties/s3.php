<?php

    class NT_S3 {
        private $client;

        private function setup_client() {
            if(!empty($this->client)) return;

            $this->client = new Aws\S3\S3Client([
                'version' => 'latest',
                'region'  => Options::get('STORAGE_S3_REGION'),
                'endpoint' => Options::get('STORAGE_S3_HOST'),
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key'    => Options::get('STORAGE_S3_KEY'),
                    'secret' => Options::get('STORAGE_S3_SECRET'),
                ],
            ]);
        }
        /**
         * Writes a file on disk in default uploads directory
         * @param {string} $name : The file name (with extension) to store the file to
         * @param {$_FILE} $file : The PHP File object to write on disk
         * @return {boolean}
         */
        public function store($name, $file) {
            $this->setup_client();

            $this->client->putObject([
                'Bucket' => Options::get('STORAGE_S3_BUCKET'),
                'Key'    => $name,
                'Body'   => 'Hello from MinIO!!'
            ]);

            return true;
        }

        /**
         * Erases a file on disk in default uploads directory
         * @param {string} $name : The name of the file to erase
         */
        public function erase($name) {
            $destination = __DIR__ . '/../../' . Options::get('UPLOADS_DIR') . '/' . $name;
            unlink($destination);
        }
    }
