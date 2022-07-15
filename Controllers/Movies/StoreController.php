<?php  

    session_start();
    require 'database/dataBaseConnection.php';
    require 'Support/GenresRepository.php';
    require 'Support/DirectorsRepository.php';
    require 'Support/FormValidator.php';
    require 'Support/MovieRepository.php';

    $conn = createConectionToDB();
    
    $listOfGenres = (new GenreRepository($conn))->getGenres();

    $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();
   
    $validator = new FormValidator($listOfDirectors, $listOfGenres);

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