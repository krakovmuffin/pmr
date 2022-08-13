<?php
    class C_Api_Doctors extends Controller {

        protected function load() {
            $this->register_service('doctors', new S_Doctors());
        }

        public function create($req, $res) {
            $payload = $req->body;
            $schema = $this->services['doctors']->get_schema();

            if(!Validator::is_valid_schema($payload, $schema))
                return $res->send_malformed();

            Validator::enforce_schema($payload, $schema);
            $this->services['doctors']->create($payload);

            $res->send_success();
        }
    }
