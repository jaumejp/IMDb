<?php
    session_start();
    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    // require 'database/fetchGenres.php'; 
    // $listOfGenres = fetchGenres($conn);
    require 'Support/GenresRepository.php';
    $listOfGenres = (new GenreRepository($conn))->getGenres();

    // require 'database/fetchDirectors.php'; 
    // $listOfDirectors = fetchDirectors($conn);
    require 'Support/DirectorsRepository.php';
    $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();
   
    require 'Support/FormValidator.php';
    $validator = new FormValidator($listOfDirectors, $listOfGenres);

    require 'Support/MovieRepository.php';

    $endpoint = '/movies/store'; 

    require 'views/movies/create.view.php'; 
