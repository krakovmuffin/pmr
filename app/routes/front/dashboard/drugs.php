<?php
    class R_Front_Dashboard_Drugs extends Router {
        protected function load() {
            $controller = new C_Front_Dashboard_Drugs();
            $this->set_prefix('/drugs');

            $this->get('/', [$controller, 'page_search']);
        }
    }

