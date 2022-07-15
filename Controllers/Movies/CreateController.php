<?php
    session_start();
    require 'database/dataBaseConnection.php';
    require 'Support/GenresRepository.php';
    require 'Support/DirectorsRepository.php';
    require 'Support/FormValidator.php';
    require 'Support/MovieRepository.php';
    
    $conn = createConectionToDB();

    $listOfGenres = (new GenreRepository($conn))->getGenres();

    $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();
   
    $validator = new FormValidator($listOfDirectors, $listOfGenres);

    $endpoint = '/movies/store'; 

    require 'views/movies/create.view.php'; 
