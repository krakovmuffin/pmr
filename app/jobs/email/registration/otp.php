<?php

    /**
     * Expected $context :
     * -> email : string, the recipient
     * -> otp : string, the otp
     */
    class J_Email_Registration_Otp extends Job {
        public function run($context) {
            $thirdparty = new NT_Emails();

            $body = $thirdparty->render('/registration/otp', $context);

            $thirdparty->send([
                'to' => $context['email'],
                'subject' => __("Here's your new one-time password"),
                'body' => $body
            ]);
        }
    }
