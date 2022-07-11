<?php

session_start();
    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    require 'database/fetchGenres.php'; 
    $listOfGenres = fetchGenres($conn);

    require 'database/fetchDirectors.php'; 
    $listOfDirectors = fetchDirectors($conn);
   
    require 'Support/FormValidator.php';
    $validator = new FormValidator($listOfDirectors, $listOfGenres);

    require 'Support/MovieRepository.php';
    require 'Support/MovieService.php'; 
    
    $editForm = true;
    
    if (! $validator->validate($editForm)) {
        // Incorrect inputs:
        $error = $validator->message;
        $_SESSION['flash_message'] = $error;  

        // Get info from the id given by the url:
        $fetchMovie = (new MovieRepository($conn))->getMovieFromDirectorId($_POST["movie-id"]);
        $movie = (new MovieService($conn))->parseListOfMovies($fetchMovie);
        // Show the form with data on inputs:
        $endpoint = '/movies/update'; 
        $showInfo = true;

        header("Location: /movies/edit?id=".$_POST["movie-id"]);
        exit;

    } else {
        // Inputs correct, edit  BBDD:
        $editMovie = new MovieRepository($conn);

        if (empty($_FILES['cover-image']['name'])) {
            $image = $_POST['old-cover-image'];
        } else {
            $image = $_FILES['cover-image'];
        }

        if (empty($_FILES['screen_shots']['name'][0])) {
            $screenShots = $_POST['old_screen-shots'];
        } else {
            $screenShots = $_FILES['screen_shots'];
        }

        $editMovie->editMovie($_POST["movie-id"], $_POST["title"], $_POST["description"], $_POST["rating"], $image, $_POST["resume"], $_POST["director-name"], $_POST["tags"], $screenShots);
        header("Location: /");
        die();

    }