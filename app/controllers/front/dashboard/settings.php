<?php

    class C_Front_Dashboard_Settings extends Controller {

        protected function load() {
            $this->register_service('settings', new S_Settings());
        }

        public function page_emails($req, $res) {
            $settings = $this->services['settings']->find_all([ 
                [
                    'column' => 'name',
                    'operator' => 'LIKE',
                    'value' => 'SMTP_%' 
                ]
            ]);
            $settings = Arrays::combine($settings, 'name', 'value');

            $res->render([
                'title' => 'Settings > Emails',
                'slug' => 'settings-emails',
                'view' => '/pages/dashboard/settings/emails',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/settings/emails.js' ]
                ],
                'context' => [
                    'settings' => $settings
                ]
            ]);
        }

        public function page_accounts($req, $res) {
            $settings = $this->services['settings']->find_all([ 
                [
                    'column' => 'name',
                    'operator' => 'LIKE',
                    'value' => 'ACCOUNT_%' 
                ]
            ]);
            $settings = Arrays::combine($settings, 'name', 'value');

            $res->render([
                'title' => 'Settings > Accounts',
                'slug' => 'settings-accounts',
                'view' => '/pages/dashboard/settings/accounts',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/settings/accounts.js' ]
                ],
                'context' => [
                    'settings' => $settings
                ]
            ]);
        }
    }
