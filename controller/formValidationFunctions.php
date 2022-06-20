<?php

    require 'importData.php';

    // Check if all inputs are filled:
    function inputsFilled($title, $resume, $description, $rating, $coverImage, $directorName, $tags) {
        if 
        (
            empty($title) || 
            empty($resume) || 
            empty($description) || 
            empty($rating) || 
            empty($coverImage) || 
            empty($directorName) || 
            empty($tags)
        ) {
            return false;
        }

        return true;
        
    }

    // Check if the rating is between 0 and 10: 
    function ratingOnRange($rating) {
        if ($rating > 0 || $rating < 10) {
            return true;
        }
        return false;
    }

    // Validate director's name:    
    function directorNameOK($directorsName) {
        if (in_array($directorsName, $listOfDirectors)) {
            return true;
        }
        return false;
    }

    // Validate the tags: 
    function tagsOK($tags) {
        foreach($tags as $tag) {
            if (!in_array($tag, $listOfGenres)) {
                return false;
            }
        }
        return true;
    }
    