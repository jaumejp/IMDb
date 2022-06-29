<?php

class FormValidator
{
    public string $message = '';
    public array $directors = [];
    public array $genres = [];

    public function __construct($listOfDirectors, $listOfGenres) {
        $this->directors = $listOfDirectors;
        $this->genres = $listOfGenres;
    }

    // Validate the form:
    public function validate(): bool {
        if (! $this->allInputsFilled($_POST["title"], $_POST["resume"], $_POST["description"])) {
            $this->message = "Please fill all the fields";
            return false;
    
        } else if (! $this->ratingOK($_POST["rating"])) {
            $this->message = "Rating must be between 0 and 10";
            return false;
    
        } else if (! $this->imageOK($_FILES["cover-image"])) {
            $this->message = "Upload a valid cover image";
            return false;
    
        } else if(! $this->directorNameOK($_POST["director-name"], $this->directors)) {
            $this->message = "Enter a valid director's name";
            return false;
    
        } else if(!isset($_POST["tags"])) {
            $this->message = "Enter at least one tag";
    
        } else if (! $this->tagsOK($_POST["tags"], $this->genres)) {
            $this->message = "Enter a valid genres";
            return false;
    
        } else if (! $this->screenShotsOK($_FILES["screen_shots"])) {
            $this->message = "Upload valid screen shots";
            return false;

        } else {
            return true;
        }
    }

    // Check if all inputs are filled:
    private function allInputsFilled($title, $resume, $description) {
        if 
        (
            empty($title) || 
            empty($resume) || 
            empty($description)
        ) {
            return false;
        }

        return true;
    }
    // Check if the rating is between 0 and 10: 
    private function ratingOK($rating) {
        if (empty($rating)) {
            return false;
        } else if ($rating < 0 || $rating > 10) {
            return false;
        }
        return true;
    }
    // Validate image: 
    private function imageOK($image) {
        // Check if the image exists:
        if (empty($image["size"])) {
            return false; 
        }
        // Check if the image has one allowed extension: 
        $file_name = $image["name"];
        $temp= explode('.',$file_name);
        $extension = end($temp);
        // allowed file type: 
        $allowed_exs = array("jpg", "jpeg", "png");
        if (in_array($extension, $allowed_exs)) {
            return true;
        }
    
        // The uploaded file is not empty but has a invalid extension:
        return false;  

    }
    // Validate director's name:    
    private function directorNameOK($directorsName, $listOfDirectors) {
        return in_array($directorsName, $listOfDirectors);
    }
    // Validate the tags: 
    private function tagsOK($tags, $listOfGenres) {
        foreach($tags as $tag) {
            if (!in_array($tag, $listOfGenres)) {
                return false;
            }
        }
        return true;
    }
    // Validate screen Shots:
    private function screenShotsOK($screenShots) {

        // Check if the image exists:
        if (empty($screenShots["size"])) {
            return false; 
        }
        // Check if the image has one allowed extension:
        foreach($screenShots["name"] as $screenShotName) {             
            $file_name = $screenShotName;
            $temp= explode('.',$file_name);
            $extension = end($temp);
            // allowed file type: 
            $allowed_exs = array("jpg", "jpeg", "png");
            if (!in_array($extension, $allowed_exs)) {
                return false;
            }
        }

        return true;
    }

}