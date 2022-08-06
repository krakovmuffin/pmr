<?php
    class R_Front extends Router {
        protected function load() {
            $this->mount(new R_Front_Login());

            $this->get('/sandbox', function($req, $res) {
                $res->render([
                    'view' => '/pages/sandbox'
                ]);
            });

            $this->get('/dashboard', native_mdw('authentication'), function($req, $res) {
                $res->send_success();
            });

            // Default redirect
            $this->use(function($req, $res) {
                $res->redirect(front_path('/sign-in'));
            });
        }
    }
