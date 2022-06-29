<?php

    session_start();
    // Requires necessaris
    require 'database/dataBaseConnection.php';
    require 'database/fetchDirectors.php'; 
    require 'database/fetchGenres.php'; 
    require 'Support/FilterValidator.php';
    require 'database/fetchMovies.php'; 
    require 'helpers/queryBuilder.php';

    $conn = createConectionToDB();

    $listOfDirectors = fetchDirectors($conn);
    $listOfGenres = fetchGenres($conn);

    // Create validator object:
    $validator = new FilterValidator($listOfDirectors, $listOfGenres);

    // Validate data from inputs: 
    if (! $validator->validate()) {
        $error = $validator->message;
        $_SESSION['flash_message'] = $error;
        $listOfMovies = [];
        require 'views/home.view.php';
        exit;
    }

    // If correct fetch data with inputs values:
    $data = getData();
    
    $query = createQueryFor($data);

    $statement = $conn->prepare($query); 
    $statement->execute();  
    $movies = $statement->fetchAll();

    $selectedFilters = [
        'title' => $_POST["title"] ?? '',
        'director' => $_POST["director-name"] ?? '',
        'ratings' => $_POST["rating"] ?? array(),
        'genres' => $_POST["tags"] ?? array(),
    ];

    if (count($movies) == 0 ) {
        $_SESSION['flash_message'] = "No movies founded!";
        $listOfMovies = [];
        require 'views/home.view.php';
        exit;
    } else {
        $listOfMovies = parseListOfMovies($movies, $conn);
        require 'views/home.view.php';
        exit;
    }

    

    
    //FilterValidator::validateRating($rating);



    // Validar inputs
    // IF NO VALID
        // Require amb missatge d'error
        // Exit

    // Preparem la query de movies amb els condicionals segons filtres
    // require 'database/fetchMovies.php'; 
    // $listOfMovies = fetchMovies($conn);
    //


    // Show data in JSON format

    // function getData() {
    //     $title = $_POST['title'];
    //     $directorName = $_POST['director-name'];
    //     $rating = ''; 
    //     $genres = '';

    //     $firstCondition = false;
    //     if (isset($_POST["rating"])) {
    //         foreach($_POST["rating"] as $score) {
    //             if (!$firstCondition) {
    //                 $rating = $rating . parseRating($score);
    //                 $firstCondition = true;
    //             } else {
    //                 $rating = $rating . " or " . parseRating($score);
    //             }
    //         }
    //     }

    //     $firstCondition = false;
    //     if (isset($_POST["tags"])) {
    //         foreach($_POST["tags"] as $tag) {
    //             if (!$firstCondition) {
    //                 $genres = $genres . " genere = '" . $tag . "'";
    //                 $firstCondition = true;
    //             } else {
    //                 $genres = $genres . " or genere = '" . $tag . "'";
    //             }
    //         }           
    //     }

        
        
    //     $data = array (
    //         "title" => $title,
    //         "directorName" => $directorName,
    //         "rating" => $rating,
    //         "genres" => $genres
    //     );

    //     return $data;
    // }



    // function createQueryFor($data) {
        
    //     $query;
    //     $firstCondition = true;

    //     /*
    //     $conditionals = [];

    //     $conditionals[] = $query;

    //     if (! $conditionals) {
    //         $query = "SELECT * FROM movies";
    //     } else {
    //         $query = "SELECT * FROM movies WHERE ";
    //         $query .= implode(' AND ', $conditionals);
    //     }
    //     */



    //     if (empty($data["title"]) && empty($data["directorName"]) && empty($data["rating"]) && empty($data["genres"])) {
    //         $query = "SELECT * FROM movies";
    //     } else {
    //         $query = "SELECT * FROM movies WHERE";

    //         if (!empty($data["title"])) {
    //             $query = $query . " (title like '%" . $data["title"] . "%' or description like '%" . $data["title"] . "%')";
    //             $firstCondition = false;
    //         } 
            
    //         if (!empty($data["directorName"])) {
    //             if ($firstCondition) {
    //                 $query = $query . " director_id = (select id from directors where name = '" . $data["directorName"] . "')";
    //                 $firstCondition = false;
    //             } else {
    //                 $query = $query . " and director_id = (select id from directors where name = '" . $data["directorName"] . "')";
    //             }
    //         }
    
    //         if (!empty($data["rating"])) {
    //             if ($firstCondition) {
    //                 $query = $query . " (" . $data["rating"] . ")";
    //                 $firstCondition = false;
    //             } else {
    //                 $query = $query . " and (" . $data["rating"] . ")";
    //             }
    //         }
    
    //         if (!empty($data["genres"])) {
    //             if ($firstCondition) {
    //                 $query = $query . " id in (select movie_id from genres_of_movies where genre_id in (select id from genres where " . $data["genres"] ."))";
    //                 $firstCondition = true;
    //             } else {
    //                 $query = $query . " and id in (select movie_id from genres_of_movies where genre_id in (select id from genres where " . $data["genres"] ."))";
    //             }

    //         }
    //     }

    //     return $query;
    // }

    