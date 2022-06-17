<?php

    // Get data from BBDD
    require 'importData.php';

    foreach($listOfMovies as $movie) {
        //var_dump($movie);
        $movieTitle = $movie->getTitle();
        $movieSummary = $movie->getSummary();
        $movieDescription = $movie->getDescription();
        $movieRating = $movie->getRating();
        $movieDirector = $movie->getDirector();
        $movieCover = $movie->getCoverImage();
        $movieScreenShots = $movie->getScreenShots();

        // genres and screenshots

        var_dump($movieTitle);       
        echo '<br><br>';
        var_dump($movieSummary);
        echo '<br><br>';
        var_dump($movieDescription);
        echo '<br><br>';
        var_dump($movieRating);
        echo '<br><br>';
        var_dump($movieDirector); 
        echo '<br><br>';
        var_dump($movieCover);  
        echo '<br><br>';
        var_dump($movieScreenShots);
        
 }
    $tit = "Avatar";
    $arr = array('title' => $tit, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
    $arr2 = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
    $arr3 = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);

    $finalArray = array();
    $finalArray[] = $arr;
    $finalArray[] = $arr2;
    $finalArray[] = $arr3;

    echo json_encode($finalArray);



    // "title": "Tenet",
    // "resume": "Armed with only one word, Tenet, and fighting for the survival of the entire world, a Protagonist journeys through a twilight world of international espionage on a mission that will unfold in something beyond real time.",
    // "description": "Armed with only one word, Tenet, and fighting for the survival of the entire world, a Protagonist journeys through a twilight world of international espionage on a mission that will unfold in something beyond real time.",
    // "score": "7.3",
    // "director": "Christopher Nolan",
    // "cover": "https://pics.filmaffinity.com/Tenet-432994986-large.jpg",
    // "genres": ["Action", "Adventure", "Sci-Fi", "Thriller"],
    // "screenshots": ["Screen1", "Screen2"]
