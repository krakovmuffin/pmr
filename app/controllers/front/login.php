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

        public function page_verify_otp($req, $res) {
            if($req->session->get('otp_requested', false) !== true)
                return $res->redirect(front_path('/sign-in'));

            $res->render([
                'title' => 'Verify OTP',
                'slug' => 'verify-otp',
                'view' => '/pages/login/verify-otp',
                'scripts' => [
                    [ 'url' => '/pages/login/verify-otp.js' ],
                    [ 'url' => '/components/otp.js' ]
                ]
            ]);
        }

        public function page_reset_password($req, $res) {
            if($req->session->get('reset_password_authorized', false) !== true)
                return $res->redirect(front_path('/sign-in'));

            $res->render([
                'title' => 'Reset password',
                'slug' => 'reset-password',
                'view' => '/pages/login/reset-password',
                'scripts' => [
                    [ 'url' => '/pages/login/reset-password.js' ]
                ]
            ]);
        }
    }
