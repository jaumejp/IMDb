<?php

session_start();

    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    // require 'database/fetchGenres.php'; 
    // $listOfGenres = fetchGenres($conn);
    require 'Support/GenresRepository.php';
    $listOfGenres = (new GenreRepository($conn))->getGenres();

    // require 'database/fetchDirectors.php'; 
    // $listOfDirectors = fetchDirectors($conn);
    require 'Support/DirectorsRepository.php';
    $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();
   
    require 'Support/FormValidator.php';
    $validator = new FormValidator($listOfDirectors, $listOfGenres);

    require 'Support/MovieRepository.php';
    require 'Support/MovieService.php'; 
    
    $editForm = true;
    
    if (! $validator->validate($editForm)) {
        // Incorrect inputs:
        $error = array(
            "result" => false,
            "message" => $validator->message
        );

        echo(json_encode($error));
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
        
        $error = array(
            "result" => true,
            "message" => $validator->message
        );

        echo(json_encode($error));
        exit;

    }