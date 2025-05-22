<?php

    // Require conection to database:
    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    // Get movie id from url. With get parameters on the url: http://imbd.test/movie?id=171
    $id = $_GET["id"];

    // Get movie info from database
    $statement = $conn->prepare("SELECT * FROM movies WHERE id = :movie_id");
    $statement->bindParam(":movie_id", $id);
    $statement->execute();  

    $movies = $statement->fetchAll();

    // Convert array from database to array of objects: 
    require 'Support/MovieService.php';
    $listOfMovies = (new MovieService($conn))->parseListOfMovies($movies);
    // Parse data: 
    $movie = [
        "title" => $listOfMovies[0]->getTitle(),
        "cover_image" =>$listOfMovies[0]->getCoverImage(),
        "director_name" =>$listOfMovies[0]->getDirector()->getName(),
        "description" =>$listOfMovies[0]->getDescription(),
        "genres_list" =>$listOfMovies[0]->getGenres(),
        "screen_shots_list" =>$listOfMovies[0]->getScreenShots(),
    ];

    // Require view (add those information to the view)
    require 'views/movies/movie.view.php';


