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
    }

