<?php

    class Director {

        // Atributes: 
        protected $id;
        protected $name;
        protected $year_of_birth;

        // Constructor:
        public function __construct($id, $name, $year_of_birth) {
            $this->id = $id;
            $this->name = $name;
            $this->year_of_birth = $year_of_birth;
        }

        // Methods:
        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getYearOfBirth() {
            return $this->year_of_birth;
        }
    }