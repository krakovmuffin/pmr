<?php

    /**
     * TODO : Test
     */
    class NM_Authentication extends Middleware {
        // Type of authentication 
        // One of : API / SESSION 
        private $type;

        // Table to look for credentials
        private $table;

        // Case when auth type is API 
        // Column to check against the supplied token
        private $column;

        // Case when auth type is API
        // HTTP header to retrieve token from
        private $header;

        public function __construct($params) {
            // Default
            $this->type = 'session';
            $this->table = 'users';
            $this->column = null;
            $this->header = null;

            // Merge
            foreach([ 'type' , 'table' , 'name' , 'header' ] as $k) {
                if(!isset($params[$k])) continue;
                $this->$k = $params[$k];
            }
        }

        public function __invoke($req, $res, &$next) {
            $service = new Service();
            $service->set_table($this->table);

            $is_session_auth = strtolower($this->type) === 'session';

            // Mechanism : Session
            if('session' === strtolower($this->type)) {
                $is_logged = $req->session->get('logged', false);

                if(!$is_logged) {
                    $next = false;
                    return $res->send_malformed();
                }

                $user_id = $req->session->get('user_id');
                $user = $service->get($user_id);

                $req->context['user'] = $user;

                return;
            }

            // Mechanism : API Token
            if('api' === strtolower($this->type)) {

                if(!isset($req->headers[$this->header])) {
                    $next = false;
                    return $res->send_malformed();
                }

                $token = $req->headers[$this->header];

                if(!$service->exists_one([ "$this->column" => $token ])) {
                    $next = false;
                    return $res->send_malformed();
                }

                $user = $service->find_one([ "$this->column" => $token ]);

                $req->context['user'] = $user;

                return;
            }
        }
    }

