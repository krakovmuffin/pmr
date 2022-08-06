<?php

    class C_Front_Login extends Controller {

        public function page_sign_in($req, $res) {
            $res->render([
                'title' => 'Sign In',
                'slug' => 'sign-in',
                'view' => '/pages/login/sign-in',
                'scripts' => [
                    [ 'url' => '/pages/login/sign-in.js' ]
                ]
            ]);
        }

        public function page_request_password_reset($req, $res) {
            $res->render([
                'title' => 'Reset Password',
                'slug' => 'request-password-reset',
                'view' => '/pages/login/request-password-reset',
                'scripts' => [
                    [ 'url' => '/pages/login/request-password-reset.js' ]
                ]
            ]);
        }
    }
