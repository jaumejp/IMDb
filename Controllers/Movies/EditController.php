<?php
   session_start();
   require 'database/dataBaseConnection.php';
   require 'Support/MovieRepository.php'; 
   require 'Support/MovieService.php'; 
   require 'Support/GenresRepository.php';
   require 'Support/DirectorsRepository.php';

   // Get connexion to database and list of directors and genres
   $conn = createConectionToDB();

   $listOfGenres = (new GenreRepository($conn))->getGenres();

   $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();

   // Get info from the id given by the url:
   $fetchMovie = (new MovieRepository($conn))->getMovieFromDirectorId($_GET["id"]);

   $movie = (new MovieService($conn))->parseListOfMovies($fetchMovie);

   // Show the form with data on inputs:
   $endpoint = '/movies/update'; 
   $showInfo = true;

   require 'views/movies/edit.view.php'; 