
<?php   

    //session_start();

    require 'helpers/formValidationFunctions.php';
    require 'helpers/parseMovieToJson.php';


    require 'database/fetchDirectors.php'; 
    $listOfDirectors = fetchDirectors($conn);

    require 'database/fetchGenres.php'; 
    $listOfGenres = fetchGenres($conn);

    //require 'database/fetchMovies.php';

    // Get and validate data from URL
    if ($error = invalidInputs($listOfDirectors, $listOfGenres)) {
        // return to form and show error message
        $_SESSION['flash_message'] = $error;
        header("Location: /");
        die();

    } else {
        // Show data in JSON format

        $data = getData();

        $query = createQueryFor($data);

        $statement = $conn->prepare($query); 
        $statement->execute();  
        $movies = $statement->fetchAll();

        if (count($movies) == 0 ) {
            //var_dump("no movies founded");
        } else {
            $listOfMovies = parseListOfMovies($movies, $conn);
            //return $listOfMovies;
            //$listOfMovies = parseToJson($listOfMovies);

            //echo $listOfMovies;
            //header("Location: /");
        }

        //return $listOfMovies;

    }
    


    


    function getData() {
        $title = $_POST['title'];
        $directorName = $_POST['director-name'];
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



    function invalidInputs($listOfDirectors, $listOfGenres) {

        // If directors exists, has to be in the list or none

        if(!empty($_POST["director-name"])) {
            if (!directorNameOK($_POST["director-name"], $listOfDirectors)) {
                return "Enter a valid director's name";
            }
        }

        // if rating isset, has to be on range, otherwise, we want all the ranges
        if (isset($_POST["rating"])) {
            if(ratingOnRange($_POST["rating"])) {
                return "Rating must be a correct option";
            }
        }

        // if tags are isset, has to be one of the list, otherwise, we want all of them.
        if (isset($_POST["tags"])) {
            if(!tagsOK($_POST["tags"], $listOfGenres)) {
                return "Enter a valid genres";
            }
        }
       
        // If we are here, all inputs are correct
        return false;

    }