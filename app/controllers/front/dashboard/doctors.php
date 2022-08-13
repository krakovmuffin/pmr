<?php

    class C_Front_Dashboard_Doctors extends Controller {
        protected function load() {
            $this->register_service('doctors', new S_Doctors());
            $this->register_service('dictionaries', new S_Dictionaries());
        }

        public function page_list($req, $res) {
            $doctors = $this->services['doctors']->get_all();
            $this->services['doctors']->group_by_alphabet($doctors);

            $res->render([
                'title' => 'Doctors > List',
                'slug' => 'doctors-list',
                'view' => '/pages/dashboard/doctors/list',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/doctors/list.js' ]
                ],
                'context' => [
                    'doctors' => $doctors
                ]
            ]);
        }

        public function page_create($req, $res) {
            // Help user with predefined values
            $specialties = $this->services['dictionaries']->all('doctors_specialties');

            $res->render([
                'title' => 'Doctors > New',
                'slug' => 'doctors-new',
                'view' => '/pages/dashboard/doctors/create',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/doctors/create.js' ]
                ],
                'context' => [
                    'specialties' => $specialties
                ]
            ]);
        }

        public function page_single($req, $res) {
            $doctor_id = $req->params['doctor_id'];

            if(!$this->services['doctors']->exists($doctor_id))
                return $res->redirect(front_path('/dashboard/doctors'));

            $current_doctor = $this->services['doctors']->get($doctor_id);
            $doctors = $this->services['doctors']->get_all();
            $this->services['doctors']->group_by_alphabet($doctors);

            $res->render([
                'title' => 'Doctors > ' . _e($current_doctor['name']) ,
                'slug' => 'doctors-single',
                'view' => '/pages/dashboard/doctors/single',
                'scripts' => [
                    [ 'url' => '/pages/dashboard/doctors/list.js' ],
                    /* [ 'url' => '/pages/dashboard/doctors/single.js' ] */
                ],
                'context' => [
                    'doctors' => $doctors,
                    'current_doctor' => $current_doctor
                ]
            ]);
        }
    }
