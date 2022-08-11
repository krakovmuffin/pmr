<?php

    class C_Api_Settings extends Controller {

        protected function load() {
            $this->register_service('settings', new S_Settings());
            $this->register_thirdparty('emails', new NT_Emails());
        }

        /**
         * @route POST /settings/emails/test
         */
        public function send_test_email($req, $res) {
            $payload = $req->body;

            $schema = [
                'SMTP_HOST' => [ 'required' , 'string' ],
                'SMTP_USER' => [ 'required' , 'email' ],
                'SMTP_PASS' => [ 'required' , 'string' ],
                'SMTP_PORT' => [ 'required' , 'numeric' ],
                'SMTP_FROM' => [ 'optional' , 'email' ],
                'SMTP_SECURITY' => [ 'optional' , 'string' ]
            ];

            if(!Validator::is_valid_schema($payload, $schema)) {
                $req->session->set('smtp_verified', false);
                return $res->send_malformed([ 'content' => [ 'error' => Validator::troubleshoot_schema($payload, $schema) ] ]);
            }

            Validator::enforce_schema($payload, $schema);
            Options::overwrite($payload);

            $user = $req->context['user'];
            $is_verified = $this->thirdparties['emails']->send([
                'to' => $user['email'],
                'subject' => __('Test email'),
                'body' => $this->thirdparties['emails']->render('/settings/test')
            ]);

            if(!$is_verified) {
                $req->session->set('smtp_verified', false);
                return $res->send_malformed([ 'content' => [ 'error' => 'email' ] ]);
            }

            $req->session->set('smtp_verified', true);

            $res->send_success();
        }

        /**
         * @route POST /settings/emails
         */
        public function save_email_settings($req, $res) {
            $payload = $req->body;

            if(!isset($payload['SMTP_ENABLED']))
                return $res->send_malformed();

            if(
                $req->session->get('smtp_verified') === false
                && $payload['SMTP_ENABLED'] === 'true'
            )
                return $res->send_unauthorized();


            // Flow - Deactivate emails
            if($payload['SMTP_ENABLED'] === 'false') {
                $this->services['settings']->find_and_update(
                    [ 'name' => 'SMTP_ENABLED' ],
                    [ 'value' => 'false' ]
                );

                return $res->send_success();
            }

            // Flow - Activate emails
            $schema = [
                'SMTP_HOST' => [ 'required' , 'string' ],
                'SMTP_USER' => [ 'required' , 'email' ],
                'SMTP_PASS' => [ 'required' , 'string' ],
                'SMTP_PORT' => [ 'required' , 'numeric' ],
                'SMTP_FROM' => [ 'optional' , 'email' ],
                'SMTP_SECURITY' => [ 'optional' , 'string' ]
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            Validator::enforce_schema($payload, $schema);
            foreach($payload as $n => $v)
                $this->services['settings']->find_and_update([ 'name' => $n ], [ 'value' => $v ]);
            $this->services['settings']->find_and_update([ 'name' => 'SMTP_ENABLED' ] , [ 'value' => 'true' ]);

            $req->session->remove('smtp_verified');

            $res->send_success();
        }

        /**
         * @route POST /settings/accounts
         */
        public function save_account_settings($req, $res) {
            $payload = $req->body;

            $schema = [
                'ACCOUNT_REGISTRATION_ENABLED' => [ 'required' , 'boolean' ],
                'ACCOUNT_PASSWORD_RESET_ENABLED' => [ 'required' , 'boolean' ],
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            Validator::enforce_schema($payload, $schema);
            foreach($payload as $n => $v)
                $this->services['settings']->find_and_update([ 'name' => $n ], [ 'value' => $v ]);

            $res->send_success();
        }

        /**
         * @route POST /settings/language
         */
        public function save_language_settings($req, $res) {
            $payload = $req->body;
            $locales = I18n::get_supported_locales();

            $schema = [
                'I18N_DEFAULT_LANGUAGE' => [ 'required' , 'string' , 'in:' . join(',', $locales) ],
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            Validator::enforce_schema($payload, $schema);
            foreach($payload as $n => $v)
                $this->services['settings']->find_and_update([ 'name' => $n ], [ 'value' => $v ]);

            $res->send_success();
        }
    }
