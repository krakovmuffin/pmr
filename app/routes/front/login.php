<?php
    class R_Front_Login extends Router {
        protected function load() {
            $controller = new C_Front_Login();

            $this->get('/sign-in', [$controller, 'page_sign_in']);
        }
    }
