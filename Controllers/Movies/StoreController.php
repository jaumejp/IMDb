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

    if (! $validator->validate()) {
        // Incorrect inputs:
        $error = $validator->message;
        $_SESSION['flash_message'] = $error;
        header("Location: /movies/create");
        exit;

    } else {
        // Inputs correct, add movie to BBDD:
        $addMovie = new MovieRepository($conn);
        $addMovie->addMovieToDatabase($_POST["title"], $_POST["description"], $_POST["rating"], $_FILES["cover-image"], $_POST["resume"], $_POST["director-name"], $_POST["tags"], $_FILES["screen_shots"]);
        header("Location: /");
        die();

    }