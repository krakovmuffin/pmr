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
                'password' => [ 'required' , 'string' ]
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            if(!$this->services['users']->exists_one([ 'email' => $payload['email'] ]))
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

            if(!$this->services['users']->exists_one([ 'email' => $payload['email'] ]))
                return $res->send_success();

            $otp = UUID::OTP();
            $req->session->set('user_email', $payload['email']);
            $req->session->set('user_otp', $otp);

            Queue::schedule('Email_Otp')
                ->for('now')
                ->with([ 'email' => $payload['email'] , 'otp' => $otp ])
                ->persist();

            return $res->send_success();
        }

        /**
         * @route POST /verify-otp
         */
        public function verify_otp($req, $res) {
            if(!$req->session->has('user_otp'))
                return $res->send_unauthorized();

            $payload = $req->body;
            $schema = [
                'otp' => [ 'required' , 'string', 'min_length:6', 'max_length:6' ],
            ];

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            if($req->session->get('user_otp') !== $payload['otp'])
                return $res->send_unauthorized();

            $req->session->remove('user_otp');
            $req->session->set('reset_password_authorized' , true);

            return $res->send_success();
        }
    }

