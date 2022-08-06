<?php
    class R_Front_Login extends Router {
        protected function load() {
            $controller = new C_Front_Login();

            $this->get('/sign-in', [$controller, 'page_sign_in']);

            if(Options::get('PASSWORD_RESET_ENABLED')) {
                $this->get('/request-password-reset', [$controller, 'page_request_password_reset']);
                /* $this->get('/reset-password', [$controller, 'page_reset_password']); */
            }
        }
    }
