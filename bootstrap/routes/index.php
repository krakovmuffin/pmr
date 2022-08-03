<?php

    class NR_Index extends Router {
        protected function load() {
            if ( !empty(Options::get('ROOT_API')) )
                $this->mount(new NR_Api());

            if ( !empty(Options::get('ROOT_FRONT')) )
                $this->mount(new NR_Front());

            if ( !empty(Options::get('ROOT_WEBHOOKS')) )
                $this->mount(new NR_Webhooks());
        }
    }
