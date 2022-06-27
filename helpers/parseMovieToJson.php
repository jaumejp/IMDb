<?php

    function parseToJson($listOfMovies) {

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
                'resume' => $movieSummary,
                'description' => $movieDescription,
                'rating' => $movieRating,
                'director' => $movieDirector,
                'coverImage' => $movieCover,
                'movieScreenShots' => $movieScreenShots,
                'genres' => $movieGenres,
            );
            
            $jsonData[] = $movieAux;
            
        }

        return json_encode($jsonData);

    }

