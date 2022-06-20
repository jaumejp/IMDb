
<?php

    // Get data from BBDD
    require 'importData.php';

    $jsonData = array();

    foreach($listOfMovies as $movie) {
        //var_dump($movie);
        $movieTitle = $movie->getTitle();
        $movieSummary = $movie->getSummary();
        $movieDescription = $movie->getDescription();
        $movieRating = $movie->getRating();
        $movieDirector = $movie->getDirector()->getName();
        $movieCover = $movie->getCoverImage();
        $movieScreenShots = $movie->getScreenShots();
        $movieGenres = $movie->getGenres();

        $movieAux = array(
            'title' => $movieTitle, 
            'resue' => $movieSummary,
            'description' => $movieDescription,
            'rating' => $movieRating,
            'director' => $movieDirector,
            'coverImage' => $movieCover,
            'movieScreenShots' => $movieScreenShots,
            'genres' => $movieGenres,
        );
        
        $jsonData[] = $movieAux;
        
    }

    echo json_encode($jsonData);