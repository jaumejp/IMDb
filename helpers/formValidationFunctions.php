<?php
    
    // Check if all inputs are filled:
    function allInputsFilled($title, $resume, $description) {
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
    function ratingOK($rating) {
        if (empty($rating)) {
            return false;
        } else if ($rating < 0 || $rating > 10) {
            return false;
        }
        return true;
    }

    // Validate director's name:    
    function directorNameOK($directorsName, $listOfDirectors) {
        if (in_array($directorsName, $listOfDirectors)) {
            return true;
        }
        return false;
    }

    // Validate the tags: 
    function tagsOK($tags, $listOfGenres) {
        foreach($tags as $tag) {
            if (!in_array($tag, $listOfGenres)) {
                return false;
            }
        }
        return true;
    }

    // Validate image: 
    function imageOK($image) {
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

    function getLocalImagePath($image, $directory) {

        // Check if the image has the correct extension:
        $file_name = $image["name"];
        $temp= explode('.',$file_name);
        $extension = end($temp);

        // allowed file type: 
        $allowed_exs = array("jpg", "jpeg", "png");

        // create a unique id name for the image and move it to uploads directory:
        $newImageName = uniqid("IMG-", true).'.'.$extension;
        $imgUploadPath = 'uploads/'.$directory.'/'.$newImageName;
        move_uploaded_file($image["tmp_name"], $imgUploadPath);

        return $imgUploadPath;
        
    }

    function screenShotsOK($screenShots) {

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

    function getLocalScreenShotPath($screenShotName, $tempUrl) {
        $file_name = $screenShotName;
        $temp= explode('.',$file_name);
        $extension = end($temp);

        $newImageName = uniqid("IMG-", true).'.'.$extension;
        $imgUploadPath = 'uploads/screenShots/'.$newImageName;
        move_uploaded_file($tempUrl, $imgUploadPath);

        return $imgUploadPath;

    }




    // Functions for searcher form
    function ratingOnRange($rating) {

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

    function parseRating($rating) {
        switch($rating) {
            case "low-score":
                return " rating < 3";
                break;

            case "medium-score":
                return " ( rating > 3 and rating < 5 ) ";
                break;

            case "high-score":
                return " rating > 8 ";
                break;
                
        }
    }
    