<?php
    class R_Front_Dashboard extends Router {
        protected function load() {
            $this->set_prefix('/dashboard');

            $this->use(native_mdw('authentication'));

            $this->get('/', function($req, $res) {
                return $res->send_success();
            });

            $this->mount(new R_Front_Dashboard_Settings());
        }
    }
