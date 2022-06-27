<?php

    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    require 'database/fetchMovies.php'; 
    $listOfMovies = fetchMovies($conn);
    
    require 'views/home.view.php';