<?php
    class R_Front_Dashboard_Doctors extends Router {
        protected function load() {
            $controller = new C_Front_Dashboard_Doctors();
            $this->set_prefix('/doctors');

            $this->get('/', [$controller, 'page_list']);

            $this->get(
                '/new',
                native_mdw(
                    'authorization',
                    [
                        'roles' => [ 'FAMILY_MANAGER' ],
                        'for' => 'FRONT'
                    ]
                ),
                [$controller, 'page_create']
            );

            $this->get(
                '/:doctor_id', 
                native_mdw(
                    'id',
                    [
                        'fallback' => front_path('/dashboard/doctors'),
                        'for' => 'FRONT',
                    ]
                ),
                [$controller, 'page_single']
            );
        }
    }
