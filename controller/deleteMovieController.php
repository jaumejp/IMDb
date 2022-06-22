<?php 

    require 'dataBaseConnection.php'; 

    // With get parameters on the url: http://imbd.test/movie/delete?id=177
    $id = $_GET["id"];

    // delete screen_shots
    $statement = $conn->prepare("DELETE FROM screen_shots WHERE movie_id = :movie_id");
    $statement->bindParam(":movie_id", $id);
    $statement->execute(); 

    // delete genres_of_movies
    $statement = $conn->prepare("DELETE FROM genres_of_movies WHERE movie_id = :movie_id");
    $statement->bindParam(":movie_id", $id);
    $statement->execute();  

    // Delete movie
    $statement = $conn->prepare("DELETE FROM movies WHERE id = :movie_id");
    $statement->bindParam(":movie_id", $id);
    $statement->execute();  


   

