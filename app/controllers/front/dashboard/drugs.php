<?php

    class C_Front_Dashboard_Drugs extends Controller {
        protected function load() {
        }

        public function page_search($req, $res) {
            $res->render([
                'title' => 'Drugs > Search',
                'slug' => 'drugs-search',
                'view' => '/pages/dashboard/drugs/search',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/drugs/search.js' ]
                ]
            ]);
        }
    }

