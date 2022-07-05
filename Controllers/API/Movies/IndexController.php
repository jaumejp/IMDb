<?php

    require 'Support/MovieService.php';
    require 'Support/MovieRepository.php'; 

    // Capturar les dades que ens envien ($_GET), http://imbd.test/api/movies?movies=all&title=tenet
    //var_dump($_GET["tags"]); die();


    // Fer algun select que ens doni una resposta del que volem mostrar de la BBDD:
    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    $data = getData();

    $query = createQueryFor($data);
    $movies =  (new MovieRepository($conn))->getDataFor($query);

    $listOfMovies = [];
    if (count($movies) == 0 ) {
        // No movies founded for these query
        //$_SESSION['flash_message'] = "No movies founded!";
        $JSONmovies = (new MovieService($conn))->parseToJson($listOfMovies);
        
    } else {
        // Query founded
        $listOfMovies = (new MovieService($conn))->parseListOfMovies($movies);
        $JSONmovies = (new MovieService($conn))->parseToJson($listOfMovies);
    }
    

    echo($JSONmovies); 


    function getData() {
        $title = $_GET['title'] ?? ''; 
        $directorName = $_GET['director-name'] ?? '';
        $rating = ''; 
        $genres = '';

        $firstCondition = false;
        if (isset($_GET["rating"])) {
            foreach($_GET["rating"] as $score) {
                if (!$firstCondition) {
                    $rating = $rating . parseRating($score);
                    $firstCondition = true;
                } else {
                    $rating = $rating." or ".parseRating($score);
                }
            }
        }
        $firstCondition = false;
        if (isset($_GET["tags"])) {
            foreach($_GET["tags"] as $tag) {
                if (!$firstCondition) {
                    $genres = $genres . " genere = '" . $tag . "'";
                    $firstCondition = true;
                } else {
                    $genres = $genres . " or genere = '" . $tag . "'";
                }
            }           
        }
        

        
        $data = array (
            "title" => $title,
            "directorName" => $directorName,
            "rating" => $rating,
            "genres" => $genres
        );
        
        return $data;
    }
    function createQueryFor($data) {
        
        $conditionals = [];

        if (!empty($data["title"])) {
            $conditionals[] = " (title like '%" . $data["title"] . "%' or description like '%" . $data["title"] . "%')";
        } 
        if (!empty($data["directorName"])) {
            $conditionals[] = " director_id in (select id from directors where name = '" . $data["directorName"] . "')";
        }
        if (!empty($data["rating"])) {
            $conditionals[] = " (" . $data["rating"] . ")";
        }
        if (!empty($data["genres"])) {
            $query = $conditionals[] = " id in (select movie_id from genres_of_movies where genre_id in (select id from genres where " . $data["genres"] ."))";
        }

        if (! $conditionals) {
            $query = "SELECT * FROM movies";
        } else {
            $query = "SELECT * FROM movies WHERE ";
            $query .= implode(' and ', $conditionals);
        }
        return $query;   
        
    }
    // These two functions are helpers for getData()
    function ratingOnRange($rating) {

        switch($rating) {
            case "low-score":
                return true;
                break;

            case "medium-score":
                return true;
                break;

            case "high-score":
                return true;
                break;
                
            default: 
                return false;
        }

    }
    function parseRating($rating) {
        switch($rating) {
            case "low-score":
                return " rating < 3";
                break;

            case "medium-score":
                return " ( rating > 3 and rating < 5 ) ";
                break;

            case "high-score":
                return " rating > 8 ";
                break;
                
        }
    }