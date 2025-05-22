<?php 

    session_start();
    require 'database/dataBaseConnection.php';
    require 'Support/MovieRepository.php';

    $conn = createConectionToDB();

    // With get parameters on the url: http://imbd.test/movie/delete?id=177
    $id = $_GET["id"];

    // Delete Movie or show error
    $deleteMovie = new MovieRepository($conn);

    if ($deleteMovie->deleteMovie($id)) {
        // Movie deleted correctly
        $error = $deleteMovie->message;
        $_SESSION['flash_message'] = $error;
        header("Location: /");
        exit;
    } else {
        // Movie not deleted
        $error = $deleteMovie->message;
        $_SESSION['flash_message'] = $error;
        header("Location: /");
        exit;
    }    



   

