<?php
   session_start();
   require 'database/dataBaseConnection.php';
   require 'Support/MovieRepository.php'; 
   require 'database/fetchDirectors.php'; 
   require 'database/fetchGenres.php'; 

   // Get connexion to database and list of directors and genres
   $conn = createConectionToDB();
   $listOfDirectors = fetchDirectors($conn);
   $listOfGenres = fetchGenres($conn);

   // Get info from the id given by the url:
   $movie = (new MovieRepository($conn))->getMovieFromDirectorId($_GET["id"]);

   // Show the form with data on inputs:
   $endpoint = '/movies/update'; 
   $showInfo = true;

   require 'views/movies/edit.view.php'; 