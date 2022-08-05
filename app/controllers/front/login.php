<?php

    class C_Front_Login extends Controller {

        public function page_sign_in($req, $res) {
            $res->render([
                'title' => 'Sign In',
                'slug' => 'sign-in',
                'view' => '/pages/login/sign-in'
            ]);
        }
    }
