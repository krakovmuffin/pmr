<?php

    class C_Api_Login extends Controller {

        protected function load() {
            $this->register_service('users', new S_Users());
        }

        /**
         * @route POST /sign-in
         */
        public function authenticate($req, $res) {
            $payload = $req->body;
            $schema = [
                'email' => [ 'required' , 'email' ],
                'password' => [ 'required' , 'string' , 'min_length:6' ]
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            if(!$this->services['users']->exists_one([ 'email' => $payload['email'] , 'verified' => true ]))
                return $res->send_unauthorized();

            $user = $this->services['users']->find_one([ 'email' => $payload['email'] ]);

            if(empty($user))
                return $res->send_unauthorized();

            $stored_hash = $user['password'];

            if(!password_verify($payload['password'], $stored_hash))
                return $res->send_unauthorized();

            $req->session->set('logged', true);
            $req->session->set('user_id', $user['pk']);

            $res->send_success();
        }

        /**
         * @route POST /request-passord-reset
         */
        public function send_otp($req, $res) {
            $payload = $req->body;
            $schema = [
                'email' => [ 'required' , 'email' ],
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            $req->session->set('otp_reset_enabled', true);

            // Send success even when account doesn't exist, to prevent account identification
            if(!$this->services['users']->exists_one([ 'email' => $payload['email'] , 'verified' => true ]))
                return $res->send_success();

            $otp = UUID::OTP();
            $req->session->set('user_email', $payload['email']);

            $this->services['users']->find_and_update(
                [ 'email' => $payload['email'] ],
                [ 'otp' => $otp ]
            );

            Queue::schedule('Email_Password_Otp')
                ->for('now')
                ->with([ 'email' => $payload['email'] , 'otp' => $otp ])
                ->persist();

            Queue::schedule('Clear_Otp')
                ->in('15 minutes')
                ->with([ 'email' => $payload['email'] ])
                ->persist();

            return $res->send_success();
        }

        /**
         * @route POST /verify-otp
         */
        public function verify_otp($req, $res) {
            if(!$req->session->has('user_email'))
                return $res->send_unauthorized();

            $email = $req->session->get('user_email');
            $payload = $req->body;
            $schema = [
                'otp' => [ 'required' , 'string', 'min_length:6', 'max_length:6' ],
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            if(!$this->services['users']->exists_one([ 'email' => $email, 'otp' => $payload['otp'] ]))
                return $res->send_unauthorized();

            // Reset the OTP
            $this->services['users']->find_and_update(
                [ 'email' => $email ],
                [ 'otp' => '[NULL]' ]
            );

            // Allow Password Reset if it's the current scenario
            if($req->session->get('otp_reset_enabled') === true)
                $req->session->set('reset_password_authorized' , true);

            // Auto-login and active the account if the current scenario is registration
            if($req->session->get('otp_registration_enabled') === true) {
                $user = $this->services['users']->find_and_update(
                    [ 'email' => $email ],
                    [ 'verified' => true ]
                )[0];
                $req->session->set('logged', true);
                $req->session->set('user_id', $user['pk']);
            }

            $req->session->remove('otp_reset_enabled');
            $req->session->remove('otp_registration_enabled');

            return $res->send_success();
        }

        /**
         * @route POST /reset-password
         */
        public function reset_password($req, $res) {
            if($req->session->get('reset_password_authorized') !== true)
                return $res->send_unauthorized();

            $payload = $req->body;
            $schema = [
                'password' => [ 'required' , 'string', 'min_length:6' ],
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            $email = $req->session->get('user_email');
            $hash = password_hash($payload['password'], PASSWORD_BCRYPT);

            $this->services['users']->find_and_update(
                [ 'email' => $email ],
                [ 'password' => $hash ]
            );

            $req->session->remove('user_email');
            $req->session->remove('reset_password_authorized');

            Queue::schedule('Email_Password_Reset')
                ->for('now')
                ->with([ 'email' => $email ])
                ->persist();

            return $res->send_success();
        }

        /**
         * @route POST /sign-up
         */
        public function sign_up($req, $res) {
            $payload = $req->body;
            $schema = [
                'email' => [ 'required' , 'email', 'unique:users' ],
                'password' => [ 'required' , 'string' , 'min_length:6' ],
                'language' => [ 'required' , 'string' , 'in:' . join(',', i18n::get_supported_locales()) ],
                'date_of_birth' => [ 'required' , 'date' ],
                'name' => [ 'required' , 'string' , 'min_length:3' ]
            ];

            if(!Validator::is_valid_schema($payload, $schema)) {
                $errors = Validator::troubleshoot_schema($payload, $schema);

                return $res->send_malformed([
                    'content' => [
                        'errors' => $errors
                    ]
                ]);
            }

            Validator::enforce_schema($payload, $schema);

            $otp = UUID::OTP();
            $payload['otp'] = $otp;
            $payload['power'] = 'FAMILY_MANAGER';
            $payload['password'] = password_hash($payload['password'], PASSWORD_BCRYPT);
            $this->services['users']->create($payload);

            $req->session->set('otp_registration_enabled', true);
            $req->session->set('user_email', $payload['email']);

            Queue::schedule('Email_Registration_Otp')
                   ->for('now')
                   ->with([ 'email' => $payload['email'] , 'otp' => $otp ])
                   ->persist();

            Queue::schedule('Clear_Otp')
                ->in('15 minutes')
                ->with([ 'email' => $payload['email'] ])
                ->persist();

            return $res->send_success();
        }
    }

