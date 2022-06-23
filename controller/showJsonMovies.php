
<?php

    // Get data from URL:


    // Get which movies do we have to show and save to $listOfMovies


    // Parse Movies
    require 'helpers/parseMovieToJson.php'; 
    $parsedData = parseToJson($listOfMovies);


    // Show parsed Movies
    echo $parsedData;

//     // Case 1: Any parameters:
//     if (empty($_GET["title"]) && empty($_GET["director-name"]) && !isset($_GET["rating"])) {
//         showAllMovies();
//     } else {
//         var_dump("adeu");
//     }
// die();

    
    // Get data from BBDD
    //require 'controller/importData.php';

    // function parseMovies($movies) {
    //     $jsonData = array();

    //     foreach($movies as $movie) {
    //         //var_dump($movie);
    //         $movieTitle = $movie->getTitle();
    //         $movieSummary = $movie->getSummary();
    //         $movieDescription = $movie->getDescription();
    //         $movieRating = $movie->getRating();
    //         $movieDirector = $movie->getDirector()->getName();
    //         $movieCover = $movie->getCoverImage();
    //         $movieScreenShots = $movie->getScreenShots();
    //         $movieGenres = $movie->getGenres();
    
    //         $movieAux = array(
    //             'title' => $movieTitle, 
    //             'resume' => $movieSummary,
    //             'description' => $movieDescription,
    //             'rating' => $movieRating,
    //             'director' => $movieDirector,
    //             'coverImage' => $movieCover,
    //             'movieScreenShots' => $movieScreenShots,
    //             'genres' => $movieGenres,
    //         );
            
    //         $jsonData[] = $movieAux;
            
    //     }
    
    //     echo json_encode($jsonData);
    // }

