<?php

    session_start();
    // Requires necessaris
    require 'database/dataBaseConnection.php';
    require 'Support/FilterValidator.php';
    require 'Support/MovieService.php';
    require 'Support/MovieRepository.php'; 
    require 'Support/GenresRepository.php';
    require 'Support/DirectorsRepository.php';

    $conn = createConectionToDB();

    $listOfGenres = (new GenreRepository($conn))->getGenres();

    $listOfDirectors = (new DirectorsRepository($conn))->getDirectors();

    // Create validator object:
    $validator = new FilterValidator($listOfDirectors, $listOfGenres);

    // Validate data from filter inputs: 
    if (! $validator->validate()) {
        $error = $validator->message;
        $_SESSION['flash_message'] = $error;
        $listOfMovies = [];
        require 'views/home.view.php';
        exit;
    }

    // If correct; fetch data with inputs values:
    $data = getData();

    $query = createQueryFor($data);
    $movies =  (new MovieRepository($conn))->getDataFor($query);
    
    $selectedFilters = [
        'title' => $_POST["title"] ?? '',
        'director' => $_POST["director-name"] ?? '',
        'ratings' => $_POST["rating"] ?? array(),
        'genres' => $_POST["tags"] ?? array(),
    ];

    $listOfMovies = [];
    if (count($movies) == 0 ) {
        $_SESSION['flash_message'] = "No movies founded!";
    } else {
        $listOfMovies = (new MovieService($conn))->parseListOfMovies($movies);
    }

    require 'views/movies/index.view.php';
    exit;

    function getData() {
        $title = $_POST['title'] ?? ''; 
        $directorName = $_POST['director-name'] ?? '';
        $rating = ''; 
        $genres = '';
    
        $firstCondition = false;
        if (isset($_POST["rating"])) {
            foreach($_POST["rating"] as $score) {
                if (!$firstCondition) {
                    $rating = $rating . parseRating($score);
                    $firstCondition = true;
                } else {
                    $rating = $rating . " or " . parseRating($score);
                }
            }
        }
    
        $firstCondition = false;
        if (isset($_POST["tags"])) {
            foreach($_POST["tags"] as $tag) {
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
        
        $query;
        $firstCondition = true;
    
        /*
        $conditionals = [];
    
        $conditionals[] = $query;
    
        if (! $conditionals) {
            $query = "SELECT * FROM movies";
        } else {
            $query = "SELECT * FROM movies WHERE ";
            $query .= implode(' AND ', $conditionals);
        }
        // Fer un array on primer l'emplanem a través de tots els ifs, posem totes les condicions i al final explotem l'array amb and pel mig
        */
    
    
    
        if (empty($data["title"]) && empty($data["directorName"]) && empty($data["rating"]) && empty($data["genres"])) {
            $query = "SELECT * FROM movies";
        } else {
            $query = "SELECT * FROM movies WHERE";
    
            if (!empty($data["title"])) {
                $query = $query . " (title like '%" . $data["title"] . "%' or description like '%" . $data["title"] . "%')";
                $firstCondition = false;
            } 
            
            if (!empty($data["directorName"])) {
                if ($firstCondition) {
                    $query = $query . " director_id = (select id from directors where name = '" . $data["directorName"] . "')";
                    $firstCondition = false;
                } else {
                    $query = $query . " and director_id = (select id from directors where name = '" . $data["directorName"] . "')";
                }
            }
    
            if (!empty($data["rating"])) {
                if ($firstCondition) {
                    $query = $query . " (" . $data["rating"] . ")";
                    $firstCondition = false;
                } else {
                    $query = $query . " and (" . $data["rating"] . ")";
                }
            }
    
            if (!empty($data["genres"])) {
                if ($firstCondition) {
                    $query = $query . " id in (select movie_id from genres_of_movies where genre_id in (select id from genres where " . $data["genres"] ."))";
                    $firstCondition = true;
                } else {
                    $query = $query . " and id in (select movie_id from genres_of_movies where genre_id in (select id from genres where " . $data["genres"] ."))";
                }
    
            }
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