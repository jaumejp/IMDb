<?php

class FilterValidator
{
    public string $message = '';
    public array $directors = [];
    public array $genres = [];

    public function __construct($listOfDirectors, $listOfGenres) {
        $this->directors = $listOfDirectors;
        $this->genres = $listOfGenres;
    }

    public function validate(): bool {
        // If directors exists, has to be in the list or none
        if(!empty($_POST["director-name"])) {
            if (! $this->directorNameOK($_POST["director-name"], $this->directors)) {
                $this->message = "Enter a valid director's name";
                return false;
            }
        }

        // if rating isset, has to be on range, otherwise, we want all the ranges
        if (isset($_POST["rating"])) {
            if($this->ratingOnRange($_POST["rating"])) {
                $this->message = "Rating must be a correct option";
                return false;
            }
        }

        // if tags are isset, has to be one of the list, otherwise, we want all of them.
        if (isset($_POST["tags"])) {
            if(! $this->tagsOK($_POST["tags"], $this->genres)) {
                $this->message = "Enter a valid genres";
                return false;
            }
        }
    
        // If we arrive here, all inputs are correct:
        return true;
    }

    // Check if rating is a valid option:
    private function ratingOnRange($rating): bool {
        switch($rating) {
            case "low-score":
                return true;
                break;

            case "medium-score":
                return true;
                break;

            case "high-score":
                return true;
                break;

            default: 
                return false;
        }
    }

    // Check if director's name is on the list of directors:
    private function directorNameOK($directorsName, $listOfDirectors): bool {
        return in_array($directorsName, $listOfDirectors);
    }

    // Given an array of tags check if all of them are in the list of genres:
    private function tagsOK($tags, $listOfGenres): bool {
        foreach($tags as $tag) {
            if (!in_array($tag, $listOfGenres)) {
                return false;
            }
        }
        return true;
    }


}