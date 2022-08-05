<?php
    class R_Front extends Router {
        protected function load() {
            $this->mount(new R_Front_Login());

            // Default redirect
            $this->use(function($req, $res) {
                $res->redirect(front_path('/sign-in'));
            });
        }
    }
