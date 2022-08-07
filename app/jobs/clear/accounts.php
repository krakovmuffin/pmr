<?php

    /**
     * Expected $context : None
     *
     * Task : Erase all accounts that are not verified
     */
    class J_Clear_Accounts extends Job {
        public function run($context) {
            $service = new Service();
            $service->set_table('users');

            $service->find_and_delete([ 'verified' => false ]);
        }
    }
