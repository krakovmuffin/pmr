<?php
    class R_Front_Dashboard_Settings extends Router {
        protected function load() {
            $controller = new C_Front_Dashboard_Settings();
            $this->set_prefix('/settings');

            $this->get('/', function($req, $res) {
                return $res->send_not_found();
            });

            $this->get('/emails', [$controller, 'page_emails']);
        }
    }

