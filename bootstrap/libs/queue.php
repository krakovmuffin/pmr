<?php

    class Queue {
        private $job;

        private $scheduled_for;

        private $schedule_frequency;
        private $schedule_from;

        private $is_exclusive;

        private $context;

        private function __construct($job) {
            $this->job = $job;
            $this->is_exclusive = false;
            $this->context = [];
        }

        public static function schedule($job) {
            return (new Queue($job));
        }

        public function exclusive() {
            $this->is_exclusive = true;
            return $this;
        }

        public function for($date) {
            if ( $date === 'now' )
                $date = date('c');

            $this->scheduled_for = $date;
            $this->is_exclusive = true;

            return $this;
        }

        public function in($interval) {
            $now = time();
            $later = $now + strtotime($interval, 0);

            $this->scheduled_for = date('c', $later);
            $this->is_exclusive = true;

            return $this;
        }

        public function every($frequency) {
            $this->schedule_frequency = $frequency;

            return $this;
        }

        public function from($date) {
            if ( $date === 'now' )
                $date = date('c');

            $this->schedule_from = $date;

            return $this;
        }

        public function with($context) {
            $this->context = $context;

            return $this;
        }

        public function persist() {
            $service = new NS_Jobs();

            $row = [
                'class' => $this->job,
                'context' => json_encode($this->context),
                'is_exclusive' => $this->is_exclusive,
                'is_running' => false,
            ];

            if ( isset($this->schedule_frequency) && isset($this->scheduled_for) )
                throw new Exception("Queue: every() and for() can't be used at the same time. Please use either every()->from() or for() alone. ");


            if ( isset($this->schedule_frequency) )
                $row = array_merge(
                    $row,
                    [
                        'schedule_frequency' => $this->schedule_frequency,
                        'schedule_from' => $this->schedule_from ?? date('c')
                    ]
                );
            elseif ( isset($this->scheduled_for) )
                $row = array_merge(
                    $row,
                    [
                        'scheduled_for' => $this->scheduled_for
                    ]
                );
            else
                throw new Exception('Queue: Please provide proper scheduling settings for the job, using every() / from() / for()');

            $service->create($row);
        }
    }

