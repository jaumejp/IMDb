<?php

    require 'dataBaseConnection.php';
    require 'Movie.php';

    // Get movies data from BBDD:
    $statement = $conn->prepare("SELECT * FROM movies"); 
    $statement->execute();  

    // Generate list of Movies:
    $listOfMovies = array();

    // fetch all movies at the same time:
    //$movies = $statement->fetchAll();
    //var_dump($movies); die();

    // fetch movie by movie:
    while ($movie = $statement->fetch()) {
        
        // Create aux movie to push it to the array:
        $movieAux = new Movie($movie["id"], $movie["title"], $movie["description"], $movie["rating"], $movie["cover_image"], $movie["director_id"], $movie["summary"]);

        array_push($listOfMovies, $movieAux);
    }

    

    



    // // Loop throw all to create dom
