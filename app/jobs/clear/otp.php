<?php

    /**
     * Expected $context : 
     * - email : string
     *
     * Task : Clear an account's OTP
     */
    class J_Clear_Otp extends Job {
        public function run($context) {
            $service = new Service();
            $service->set_table('users');

            $service->find_and_update(
                [ 'email' => $context['email'] ],
                [ 'otp' => '[NULL]' ]
            );
        }
    }

