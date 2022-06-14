<?php

    class Movie {

        // Atributes: 
        protected $id;
        protected $title;
        protected $description;
        protected $rating;
        protected $cover_image;
        protected $director_id;
        protected $summary;

        // Constructor:
        public function __construct($id, $title, $description, $rating, $cover_image, $director_id, $summary) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->rating = $rating;
            $this->cover_image = $cover_image;
            $this->director_id = $director_id;
            $this->summary = $summary;
        }

        // Methods:
        public function getTitle() {
            return $this->title;
        }

        public function getRating() {
            return $this->rating;
        }

        public function getDescription() {
            return $this->description;
        }

        public function getCoverImage() {
            return $this->cover_image;
        }



        public function setRating($newRating) {
            $this->rating = newRating;
        }

    }