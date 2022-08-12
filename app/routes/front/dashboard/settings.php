<?php
    class R_Front_Dashboard_Settings extends Router {
        protected function load() {
            $controller = new C_Front_Dashboard_Settings();
            $this->set_prefix('/settings');

            $this->use(
                native_mdw(
                    'authorization',
                    [
                        'roles' => [ 'FAMILY_MANAGER' ],
                        'for' => 'FRONT'
                    ]
                )
            );

            $this->get('/', function($req, $res) {
                $res->redirect(front_path('/dashboard/settings/about'));
            });

            $this->get('/about', [$controller, 'page_about']);
            $this->get('/emails', [$controller, 'page_emails']);
            $this->get('/accounts', [$controller, 'page_accounts']);
            $this->get('/language', [$controller, 'page_language']);
            $this->get('/storage', [$controller, 'page_storage']);
        }
    }
