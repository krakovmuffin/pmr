<?php

    class C_Front_Dashboard_Settings extends Controller {

        public function page_emails($req, $res) {
            $res->render([
                'title' => 'Settings > Emails',
                'slug' => 'settings-emails',
                'view' => '/pages/dashboard/settings/emails',
                'scripts' => [
                    /* [ 'url' => '/pages/login/sign-in.js' ] */
                ]
            ]);
        }
    }
