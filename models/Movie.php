<?php

    class Movie {

        // Atributes: 
        protected $id;
        protected $title;
        protected $description;
        protected $rating;
        protected $cover_image;
        protected $director;
        protected $summary;
        protected $genres;
        protected $screen_shots;


        // Constructor:
        public function __construct($id, $title, $description, $rating, $cover_image, $summary) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->rating = $rating;
            $this->cover_image = $cover_image;
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

        public function getSummary() {
            return $this->summary;
        }


        public function getDirector() {
            return $this->director;
        }
        public function setDirector($director) {
            $this->director = $director;
        }

        public function setGenres($genres) {
            $this->genres = $genres;
        }
        public function getGenres() {
            return $this->genres;
        }

        public function setScreenShots($screen_shotsList) {
            $this->screen_shots = $screen_shotsList;
        }

        public function getScreenShots() {
            return $this->screen_shots;
        }

        // "director": "Christopher Nolan",
        // "genres": ["Action", "Adventure", "Sci-Fi", "Thriller"],
        // "screenshots": ["Screen1", "Screen2"]



    }