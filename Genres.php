<?php

    class Movie {

        // Atributes: 
        protected $id;
        protected $genere;

        // Constructor:
        public function __construct($id, $genere) {
            $this->id = $id;
            $this->title = $genere;
        }

        // Methods:
        public function getGenere() {
            return $this->genere;
        }




    }