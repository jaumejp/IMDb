<?php 

    require 'database/dataBaseConnection.php'; 

    // With get parameters on the url: http://imbd.test/movie?id=171
    $id = $_GET["id"];

    $statement = $conn->prepare("SELECT title FROM movies WHERE id = :movie_id");
    $statement->bindParam(":movie_id", $id);
    $statement->execute();  

    $movies = $statement->fetchAll();

    foreach ($movies as $movie) {

        var_dump($movie);
    }

