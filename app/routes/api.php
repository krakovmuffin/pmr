<?php
    class R_Api extends Router {
        protected function load() {
            /**
             * Add support for :
             * - HTTP default security good practice
             * - CORS for JS XHR
             * - JSON + Form user input decoding
             * - Anti-request tampering
             */
            $this->use(native_mdw('security'));
            $this->use(native_mdw('cors'));
            $this->use(native_mdw('json'));
            $this->use(native_mdw('form'));
            $this->use(native_mdw('signature'));

            /**
             * Mount app's routers
             */
            $this->mount(new R_Api_Login());
            $this->mount(new R_Api_Settings());
            $this->mount(new R_Api_Doctors());

            /**
             * Setup default errors handler
             */
            $this->set_error_handler(function($req, $res, &$next, $err) {
                $content = [];

                if(Options::get('MODE') === 'DEBUG')
                    $content['error'] = strval($err);

                $res->send_error([ 'content' => $content ]);

                $next = false;
            });
        }
    }
