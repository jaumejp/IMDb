<?php

    require 'database/fetchMovies.php'; 

    $listOfMovies = fetchMovies();
    
    require 'views/addMovieForm.view.php';