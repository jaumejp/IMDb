<?php

    class ScreenShots {

        // Atributes: 
        protected $id;
        protected $url;
        protected $movie_id;

        // Constructor:
        public function __construct($id, $url, $movie_id) {
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





    }