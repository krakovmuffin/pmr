<?php

    class NR_Webhooks extends Router {
        protected function load() {
            $this->set_prefix( Options::get('ROOT_WEBHOOKS') );
            $this->mount(new R_Webhooks());

            // Default not-found handler
            $this->use(function($req, $res) {
                $res->send_not_found();
            });
        }
    }

