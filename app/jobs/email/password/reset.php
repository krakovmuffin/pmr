<?php

    /**
     * Expected $context :
     * -> email : string, the recipient
     */
    class J_Email_Password_Reset extends Job {
        public function run($context) {
            $thirdparty = new NT_Emails();

            $body = $thirdparty->render('/password/reset');

            $thirdparty->send([
                'to' => $context['email'],
                'subject' => __("Your password was changed"),
                'body' => $body
            ]);
        }
    }


