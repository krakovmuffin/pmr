<?php
    class R_Front extends Router {
        protected function load() {
            $this->mount(new R_Front_Login());
            $this->mount(new R_Front_Dashboard());

            $this->get('/sandbox', function($req, $res) {
                $res->render([
                    'view' => '/pages/sandbox'
                ]);
            });

            // Default redirect
            $this->use(function($req, $res) {
                $res->redirect(front_path('/sign-in'));
            });

            // Default error handler
            $this->set_error_handler(function($req, $res, &$next, $err) {
                if(Options::get('MODE') === 'DEBUG')
                    throw $err;

                $next = false;
            });
        }
    }
