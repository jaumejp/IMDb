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

    if (! $validator->validate(true)) {
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
        $editMovie->editMovie($_POST["movie-id"], $_POST["title"], $_POST["description"], $_POST["rating"], $_FILES["cover-image"], $_POST["resume"], $_POST["director-name"], $_POST["tags"], $_FILES["screen_shots"]["name"]);
        header("Location: /");
        die();

    }