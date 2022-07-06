<?php 

    session_start();
    require 'database/dataBaseConnection.php';
    require 'Support/MovieRepository.php';

    $conn = createConectionToDB();

    $id = $_GET["id"];

    // Delete Movie or show error
    $deleteMovie = new MovieRepository($conn);

    $data = array();
    if ($isMovieDeleted = $deleteMovie->deleteMovie($id)) {
        // Movie deleted correctly
        $data[] = $id;
        $jsonMessage = createJsonMessage($isMovieDeleted, $deleteMovie->message, $data);
        
    } else {
        // Movie not deleted
        $data[] = "No data";
        $jsonMessage = createJsonMessage($isMovieDeleted, $deleteMovie->message, $data);

    }    

    echo($jsonMessage);


    function createJsonMessage($isMovieDeleted, $message, $data) {
        $jsonData = array();

        $movieAux = array(
            'result' => $isMovieDeleted,
            'message' => $message, 
            'data' => $data,
        );
        
        $jsonData[] = $movieAux;

        return json_encode($jsonData);

    
    }