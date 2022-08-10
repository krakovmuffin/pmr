<?php
    class R_Api_Settings extends Router {
        protected function load() {
            $controller = new C_Api_Settings();
            $this->set_prefix('/settings');

            $this->use(native_mdw('authentication', [ 'for' => 'API' ]));

            $this->post('/emails/test', [$controller, 'send_test_email']);
            $this->post('/emails', [$controller, 'save_email_settings']);
        }
    }
