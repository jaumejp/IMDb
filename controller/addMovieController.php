<?php

    session_start();
   
    require 'helpers/formValidationFunctions.php';

    require 'database/dataBaseConnection.php';

    require 'database/fetchMovies.php'; 
    $listOfMovies = fetchMovies();

    require 'database/fetchDirectors.php'; 
    $listOfDirectors = fetchDirectors();

    require 'database/fetchGenres.php'; 
    $listOfGenres = fetchGenres();

    if ($error = invalidInputs($listOfDirectors, $listOfGenres)) {
        // Incorrect inputs:
        $_SESSION['flash_message'] = $error;
        header("Location: /movies/create");
        die();

    } else {
        // Inputs correct, add movie to BBDD:
        addMovieToDatabase();
        header("Location: /");
        die();
    }


    function invalidInputs($listOfDirectors, $listOfGenres) {
        if (!allInputsFilled($_POST["title"], $_POST["resume"], $_POST["description"])) {
            return "Please fill all the fields";
    
        } else if (!ratingOK($_POST["rating"])) {
            return "Rating must be between 0 and 10";
    
        } else if (!imageOK($_FILES["cover-image"])) {
            return "Upload a valid cover image";
    
        } else if(!directorNameOK($_POST["director-name"], $listOfDirectors)) {
            return "Enter a valid director's name";
    
        } else if(!isset($_POST["tags"])) {
            return "Enter at least one tag";
    
        } else if (!tagsOK($_POST["tags"], $listOfGenres)) {
            return "Enter a valid genres";
    
        } else if (!screenShotsOK($_FILES["screen_shots"])) {
            return "Upload valid screen shots";
        } else {
            return false;
        }
    }

    function addMovieToDatabase() {
        require 'database/dataBaseConnection.php';

        // Get data from inputs:
        $title = $_POST["title"];
        $description = $_POST["description"];
        $rating = $_POST["rating"];
        $coverImageUrl = getLocalImagePath($_FILES["cover-image"], "coverImages");
        $resume = $_POST["resume"];
        $directorName = $_POST["director-name"];
        $tags = $_POST["tags"];   

        // director id
        $statement = $conn->prepare("SELECT id FROM directors WHERE name = :movie_director");
        $statement->bindParam(":movie_director", $directorName);
        $statement->execute();   
        $director = $statement->fetch();
        $directorId = $director["id"];
      
        // Insert movie to database:
        $statement = $conn->prepare("INSERT INTO movies (title, description, rating, cover_image, director_id, summary) VALUES (:title, :description, :rating, :cover_image, :director_id, :summary)");
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":rating", $rating);
        $statement->bindParam(":cover_image", $coverImageUrl);
        $statement->bindParam(":director_id", $directorId);
        $statement->bindParam(":summary", $resume);
        $statement->execute();
        $movieId = $conn->lastInsertId();

        // Insert genres of the movie to database:
        $insertStatement = $conn->prepare("INSERT INTO genres_of_movies (movie_id, genre_id) VALUES (:movie_id, :genre_id)");
        foreach($tags as $tag) {
            $statement = $conn->prepare("SELECT id FROM genres WHERE genere = :genre");
            $statement->bindParam(":genre", $tag);
            $statement->execute();  
            $genre = $statement->fetch(); 
            $gensreId = $genre["id"];
            
            // Execute insert: 
            $insertStatement->bindParam(":movie_id", $movieId);
            $insertStatement->bindParam(":genre_id", $gensreId);
            $insertStatement->execute();
        }

        // Insert screen shots to database: 
        $insertScreenShot = $conn->prepare("INSERT INTO screen_shots (url, movie_id) VALUES (:url, :movie_id)");
        
        for ($i = 0; $i < sizeof($_FILES["screen_shots"]["name"]); $i++) {
            $screenShotName = $_FILES["screen_shots"]["name"][$i];
            $tempUrl = $_FILES["screen_shots"]["tmp_name"][$i];
            $screenShotUrl = getLocalScreenShotPath($screenShotName, $tempUrl);
            $insertScreenShot->bindParam(":url", $screenShotUrl);
            $insertScreenShot->bindParam(":movie_id", $movieId);
            $insertScreenShot->execute();
        }
    }


    // if (!allInputsFilled($_POST["title"], $_POST["resume"], $_POST["description"])) {
    //     $error = "Please fill all the fields";

    // } else if (!ratingOK($_POST["rating"])) {
    //     $error = "Rating must be between 0 and 10";

    // } else if (!imageOK($_FILES["cover-image"])) {
    //     $error = "Upload a valid cover image";

    // } else if(!directorNameOK($_POST["director-name"], $listOfDirectors)) {
    //     $error = "Enter a valid director's name";

    // } else if(!isset($_POST["tags"])) {
    //     $error = "Enter at least one tag";

    // } else if (!tagsOK($_POST["tags"], $listOfGenres)) {
    //     $error = "Enter a valid genres";

    // } else if (!screenShotsOK($_FILES["screen_shots"])) {
    //     $error = "Upload valid screen shots";
    // } else {
    //     // Add data to BBDD
    //     var_dump("all files are OK!");

    //     $title = $_POST["title"];
    //     $description = $_POST["description"];
    //     $rating = $_POST["rating"];
    //     $coverImageUrl = getLocalImagePath($_FILES["cover-image"], "coverImages");
    //     $resume = $_POST["resume"];
    //     $directorName = $_POST["director-name"];
    //     $tags = $_POST["tags"];   

    //     // director id
    //     $statement = $conn->prepare("SELECT id FROM directors WHERE name = :movie_director");
    //     $statement->bindParam(":movie_director", $directorName);
    //     $statement->execute();   
    //     $director = $statement->fetch();
    //     $directorId = $director["id"];
      
    //     // Insert movie to database:
    //     $statement = $conn->prepare("INSERT INTO movies (title, description, rating, cover_image, director_id, summary) VALUES (:title, :description, :rating, :cover_image, :director_id, :summary)");
    //     $statement->bindParam(":title", $title);
    //     $statement->bindParam(":description", $description);
    //     $statement->bindParam(":rating", $rating);
    //     $statement->bindParam(":cover_image", $coverImageUrl);
    //     $statement->bindParam(":director_id", $directorId);
    //     $statement->bindParam(":summary", $resume);
    //     $statement->execute();
    //     $movieId = $conn->lastInsertId();

    //     // Insert genres of the movie to database:
    //     $insertStatement = $conn->prepare("INSERT INTO genres_of_movies (movie_id, genre_id) VALUES (:movie_id, :genre_id)");
    //     foreach($tags as $tag) {
    //         $statement = $conn->prepare("SELECT id FROM genres WHERE genere = :genre");
    //         $statement->bindParam(":genre", $tag);
    //         $statement->execute();  
    //         $genre = $statement->fetch(); 
    //         $gensreId = $genre["id"];
            
    //         // Execute insert: 
    //         $insertStatement->bindParam(":movie_id", $movieId);
    //         $insertStatement->bindParam(":genre_id", $gensreId);
    //         $insertStatement->execute();
    //     }

    //     // Insert screen shots to database: 
    //     $insertScreenShot = $conn->prepare("INSERT INTO screen_shots (url, movie_id) VALUES (:url, :movie_id)");
        
    //     for ($i = 0; $i < sizeof($_FILES["screen_shots"]["name"]); $i++) {
    //         $screenShotName = $_FILES["screen_shots"]["name"][$i];
    //         $tempUrl = $_FILES["screen_shots"]["tmp_name"][$i];
    //         $screenShotUrl = getLocalScreenShotPath($screenShotName, $tempUrl);
    //         $insertScreenShot->bindParam(":url", $screenShotUrl);
    //         $insertScreenShot->bindParam(":movie_id", $movieId);
    //         $insertScreenShot->execute();
    //     }

    // }

    // $_SESSION['flash_message'] = $error; 

    // //header("Location: /movies/create?errMsg=$error");
    // header("Location: /movies/create");




