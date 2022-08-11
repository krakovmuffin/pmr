<?php
    class R_Front_Login extends Router {
        protected function load() {
            $controller = new C_Front_Login();

            $this->get('/sign-in', [$controller, 'page_sign_in']);

            if(Options::get('ACCOUNT_PASSWORD_RESET_ENABLED')) {
                $this->get('/request-password-reset', [$controller, 'page_request_password_reset']);
                $this->get('/verify-otp', [$controller, 'page_verify_otp']);
                $this->get('/reset-password', [$controller, 'page_reset_password']);
            }

            if(Options::get('ACCOUNT_REGISTRATION_ENABLED')) {
                $this->get('/sign-up', [$controller, 'page_sign_up']);
            }
        }
    }
