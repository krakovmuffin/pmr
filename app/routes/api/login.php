<?php
    class R_Api_Login extends Router {
        protected function load() {
            $controller = new C_Api_Login();

            $this->post('/sign-in', [$controller, 'authenticate']);

            if(Options::get('PASSWORD_RESET_ENABLED')) {
                $this->post('/request-password-reset', [$controller, 'send_otp']);
                $this->post('/verify-otp', [$controller, 'verify_otp']);
                $this->post('/reset-password', [$controller, 'reset_password']);
            }
        }
    }
