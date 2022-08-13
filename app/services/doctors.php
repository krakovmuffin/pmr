<?php

    class S_Doctors extends Service {
        protected function load() {
            $this->table = 'doctors';
            $this->schema = [
                'name' => [ 'required' , 'string' ],
                'specialty' => [ 'optional' , 'string' ],

                'email' => [ 'optional' , 'email' ],
                'phone' => [ 'optional' , 'string' ],

                'address_line' => [ 'optional' , 'string' ],
                'address_city' => [ 'optional' , 'string' ],
                'address_zip' => [ 'optional' , 'string' ],
                'address_state' => [ 'optional' , 'string' ],
                'address_country' => [ 'optional' , 'string' ],

                'note' => [ 'optional' , 'string' ]
            ];
        }

        public function group_by_alphabet(&$doctors) {
            $tmp = [];
            foreach($doctors as $doctor) {
                $name = $doctor['name'];
                $letter = ucfirst($name[0]);

                if(!isset($tmp[$letter])) $tmp[$letter] = [];

                $tmp[$letter][] = $doctor;
            }
            $doctors = $tmp; 
            ksort($doctors);
        }
    }
