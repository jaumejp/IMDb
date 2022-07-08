<?php

    
    require 'Support/MovieService.php';
    require 'Support/MovieRepository.php'; 
    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    $query = "SELECT * FROM movies WHERE id = " . $_GET["id"];
    $movies =  (new MovieRepository($conn))->getDataFor($query);
    $listOfMovies = (new MovieService($conn))->parseListOfMovies($movies);
    $JSONmovies = (new MovieService($conn))->parseToJson($listOfMovies);

    echo($JSONmovies);  