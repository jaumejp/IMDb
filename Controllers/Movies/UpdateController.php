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
        header("Location: /movies/edit");
        exit;

    } else {
        // Inputs correct, edit  BBDD:
        //$editMovie = new MovieRepository($_POST["title"], $_POST["description"], $_POST["rating"], $_FILES["cover-image"], $_POST["resume"], $_POST["director-name"], $_POST["tags"], $_FILES["screen_shots"]["name"], $conn);
        // Com puc accedir a l'id de la peli, si estic amb una petició post, input invisible?
        //$editMovie->editMovie($id);
        header("Location: /");
        die();

    }

     
   // TODO

   // validate inputs. 

   // if correct, update movie

   // Go to home page

    