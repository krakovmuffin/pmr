<?php
    class S_Settings extends Service {
        protected function load() {
            $this->table = 'settings';
        }

        public function get_all_for($keyword) {
            $settings = $this->find_all([ 
                [
                    'column' => 'name',
                    'operator' => 'LIKE',
                    'value' => $keyword .'_%' 
                ]
            ]);
            $settings = Arrays::combine($settings, 'name', 'value');
            return $settings;
        }
    }
