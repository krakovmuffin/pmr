<?php
    class R_Api_Settings extends Router {
        protected function load() {
            $controller = new C_Api_Settings();
            $this->set_prefix('/settings');

            $this->use(native_mdw('authentication', [ 'for' => 'API' ]));

            $this->use(
                native_mdw(
                    'authorization',
                    [
                        'roles' => [ 'FAMILY_MANAGER' ],
                        'for' => 'API'
                    ]
                )
            );

            $this->post('/emails/test', [$controller, 'send_test_email']);
            $this->post('/emails', [$controller, 'save_email_settings']);

            $this->post('/accounts', [$controller, 'save_account_settings']);

            $this->post('/language', [$controller, 'save_language_settings']);

            $this->post('/storage/test/s3', [$controller, 'test_storage_s3']);
            $this->post('/storage', [$controller, 'save_storage_settings']);
        }
    }
