<?php

    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    require 'database/fetchMovies.php'; 
    $listOfMovies = fetchMovies($conn);

    require 'database/fetchGenres.php'; 
    $listOfGenres = fetchGenres($conn);

    require 'database/fetchDirectors.php'; 
    $listOfDirectors = fetchDirectors($conn);

    
    require 'views/addMovieForm.view.php'; 