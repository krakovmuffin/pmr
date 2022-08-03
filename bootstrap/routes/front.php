<?php

    class NR_Front extends Router {
        protected function load() {
            $this->set_prefix( Options::get('ROOT_FRONT') );
            $this->mount(new R_Front());
        }
    }

