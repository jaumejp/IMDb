<?php
    session_start();
    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    require 'database/fetchGenres.php'; 
    $listOfGenres = fetchGenres($conn);

    require 'database/fetchDirectors.php'; 
    $listOfDirectors = fetchDirectors($conn);
   
    require 'helpers/formValidationFunctions.php';

    require 'Support/FormValidator.php';
    $validator = new FormValidator($listOfDirectors, $listOfGenres);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (! $validator->validate()) {
            // Incorrect inputs:
            $error = $validator->message;
            $_SESSION['flash_message'] = $error;
            header("Location: /movies/create");
            exit;
    
        } else {
            // Inputs correct, add movie to BBDD:
            addMovieToDatabase($conn);
            header("Location: /");
            die();
        }
    }

    require 'views/addMovieForm.view.php'; 


    function addMovieToDatabase($conn) {

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


