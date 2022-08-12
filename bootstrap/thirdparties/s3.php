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
         * Writes a file to an S3-compatible server bucket
         * @param {string} $name : The resource name to store the file to
         * @param {$_FILE} $file : The raw content to store
         * @return {boolean}
         */
        public function store($name, $content) {
            $this->setup_client();

            try {
                $this->client->putObject([
                    'Bucket' => Options::get('STORAGE_S3_BUCKET'),
                    'Key'    => $name,
                    'Body'   => $content
                ]);
            } catch (Throwable $e) {
                /* throw $e; */
                return false;
            }

            return true;
        }

        /**
         * Erases a file on disk in default uploads directory
         * @param {string} $name : The name of the file to erase
         */
        public function get($name) {
            $this->setup_client();
            $content = null;

            try {
                $content = $this->client->getObject([
                    'Bucket' => Options::get('STORAGE_S3_BUCKET'),
                    'Key'    => $name,
                ]);
            } catch (Throwable $e) {
                /* throw $e; */
                return $content;
            }

            return (string) $content['Body'];
        }
    }
