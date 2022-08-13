<?php
    class R_Api_Doctors extends Router {
        protected function load() {
            $controller = new C_Api_Doctors();
            $this->set_prefix('/doctors');

            $this->post('/', [$controller, 'create']);
        }
    }

