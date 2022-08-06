<?php
    class R_Api_Login extends Router {
        protected function load() {
            $controller = new C_Api_Login();

            $this->post('/sign-in', [$controller, 'authenticate']);
            $this->post('/request-password-reset', [$controller, 'send_otp']);
            $this->post('/verify-otp', [$controller, 'verify_otp']);
        }
    }
