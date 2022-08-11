<?php

    class C_Front_Dashboard_Settings extends Controller {

        protected function load() {
            $this->register_service('settings', new S_Settings());
        }

        public function page_emails($req, $res) {
            $settings = $this->services['settings']->get_all_for('SMTP');

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
            $settings = $this->services['settings']->get_all_for('ACCOUNT');

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

        public function page_language($req, $res) {
            $locales = I18n::get_supported_locales();
            $settings = $this->services['settings']->get_all_for('I18N');

            $res->render([
                'title' => 'Settings > Language',
                'slug' => 'settings-language',
                'view' => '/pages/dashboard/settings/language',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/settings/language.js' ]
                ],
                'context' => [
                    'settings' => $settings,
                    'available_locales' => $locales
                ]
            ]);
        }
    }
