<?php

    class NM_Signature extends Middleware {
        public function __invoke($req, $res, &$next) {
            if ( Options::get('ENABLE_ANTI_TAMPERING') === false ) return;

            if(empty($req->headers['x-adriel-signature'])) {
                $next = false;
                return $res->send_malformed();
            }

            $supplied_signature = $req->headers['x-adriel-signature'];   

            if($req->method === 'GET')
                $computed_signature = base64_encode(hash_hmac('sha256', $req->uri, Options::get('SIGNATURE_SECRET'), true));
            else
                $computed_signature = base64_encode(hash_hmac('sha256', $req->raw, Options::get('SIGNATURE_SECRET'), true));

            if($computed_signature !== $supplied_signature) {
                $next = false;
                return $res->send_malformed();
            }
        }
    }
