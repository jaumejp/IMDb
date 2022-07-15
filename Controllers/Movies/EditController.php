<?php
   session_start();
   require 'database/dataBaseConnection.php';
   require 'Support/MovieRepository.php'; 
   require 'Support/MovieService.php'; 

   // Get connexion to database and list of directors and genres
   $conn = createConectionToDB();

    // require 'database/fetchGenres.php'; 
    // $listOfGenres = fetchGenres($conn);
    require 'Support/GenresRepository.php';
    $listOfGenres = (new GenreRepository($conn))->getGenres();

    // require 'database/fetchDirectors.php'; 
    // $listOfDirectors = fetchDirectors($conn);
    require 'Support/DirectorsRepository.php';
    $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();

   // Get info from the id given by the url:
   $fetchMovie = (new MovieRepository($conn))->getMovieFromDirectorId($_GET["id"]);

   $movie = (new MovieService($conn))->parseListOfMovies($fetchMovie);

   // Show the form with data on inputs:
   $endpoint = '/movies/update'; 
   $showInfo = true;

   require 'views/movies/edit.view.php'; 