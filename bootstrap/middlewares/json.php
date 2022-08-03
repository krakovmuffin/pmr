<?php

    class NM_Json extends Middleware {
        public function __invoke($req, $res) {
            if ( !isset($req->headers['content-type']) )
                return;

            if( !str_contains($req->headers['content-type'], 'application/json') )
                return;

            $body = json_decode($req->raw, true);

            if ( json_last_error() !== JSON_ERROR_NONE )
                $body = null;

            $req->body = $body;
        }
    }

