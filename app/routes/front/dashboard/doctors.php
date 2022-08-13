<?php
    class R_Front_Dashboard_Doctors extends Router {
        protected function load() {
            $controller = new C_Front_Dashboard_Doctors();
            $this->set_prefix('/doctors');

            $this->get('/', [$controller, 'page_list']);
            $this->get('/new', [$controller, 'page_create']);
            $this->get('/:doctor_id', [$controller, 'page_single']);
        }
    }
