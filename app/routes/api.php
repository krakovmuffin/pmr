<?php
    class R_Api extends Router {
        protected function load() {
            $this->use(native_mdw('security'));
            $this->use(native_mdw('cors'));
            $this->use(native_mdw('json'));
            $this->use(native_mdw('form'));
            $this->use(native_mdw('signature'));
        }
    }
