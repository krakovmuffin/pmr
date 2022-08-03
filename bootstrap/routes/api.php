<?php

    class NR_Api extends Router {
        protected function load() {
            $this->set_prefix( Options::get('ROOT_API') );
            $this->mount(new R_Api());

            // Default not-found handler
            $this->use(function($req, $res) {
                $res->send_not_found();
            });
        }
    }

