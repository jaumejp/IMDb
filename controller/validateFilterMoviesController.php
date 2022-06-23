
<?php   

    session_start();

    require 'helpers/formValidationFunctions.php';

    require 'database/dataBaseConnection.php';
    $conn = createConectionToDB();

    require 'database/fetchDirectors.php'; 
    $listOfDirectors = fetchDirectors($conn);

    require 'database/fetchGenres.php'; 
    $listOfGenres = fetchGenres($conn);

    // Get and validate data from URL
    if ($error = invalidInputs($listOfDirectors, $listOfGenres)) {
        // return to form and show error message
        $_SESSION['flash_message'] = $error;
        header("Location: /movies/search");
        die();
    } else {
        $data = getData();

        $query = createQueryFor($data);
        
        $statement = $conn->prepare($query); 
        $statement->execute();  

        // fetch all movies at the same time:
        $movies = $statement->fetchAll();
        var_dump($movies); die();

    }




    function getData() {
        $title = $_POST['title'];
        $directorName = $_POST['director-name'];
        $rating = ''; 
        $genresList = array();

        if (isset($_POST["rating"])) {
            $rating = parseRating($_POST["rating"]);
        }

        if (isset($_POST["tags"])) {
            foreach($_POST["tags"] as $tag) {
                $genresList[] = $tag;
            }
        }

        
        
        $data = array (
            "title" => $title,
            "directorName" => $directorName,
            "rating" => $rating,
            "genres" => $genresList
        );

        return $data;
    }



    function createQueryFor($data) {

        $query;

        if (!empty($data["title"]) & empty($data["directorName"]) & empty($data["rating"]) & empty($data["genres"])) {
            // Only title
            $query = "SELECT * FROM movies WHERE title or description = '%text%'";

        } else if (empty($data["title"]) & !empty($data["directorName"]) & empty($data["rating"]) & empty($data["genres"])) {
            // Only director
            $query = "SELECT * from movies where director_id = (select id from directors where name = 'director_name')"; 

        } else if (empty($data["title"]) & empty($data["directorName"]) & !empty($data["rating"]) & empty($data["genres"])) {
            // Only rating
            $query = "";

        } else if (empty($data["title"]) & empty($data["directorName"]) & empty($data["rating"]) & !empty($data["genres"])) {
            // Only genres
            $query = "";

        } else if (!empty($data["title"]) & !empty($data["directorName"]) & empty($data["rating"]) & empty($data["genres"])) {
            // Title and director
            $query = "";

        } else if (!empty($data["title"]) & empty($data["directorName"]) & !empty($data["rating"]) & empty($data["genres"])) {
            // Title and rating
            $query = "";

        } else if (!empty($data["title"]) & empty($data["directorName"]) & empty($data["rating"]) & !empty($data["genres"])) {
            // Title and genres
            $query = "";

        } else if (empty($data["title"]) & !empty($data["directorName"]) & !empty($data["rating"]) & empty($data["genres"])) {
            // Director and rating
            $query = "";

        } else if (empty($data["title"]) & !empty($data["directorName"]) & empty($data["rating"]) & !empty($data["genres"])) {
            // Director and genres
            $query = "";

        } else if (empty($data["title"]) & empty($data["directorName"]) & !empty($data["rating"]) & !empty($data["genres"])) {
            // Genres and rating
            $query = "";

        } else if (!empty($data["title"]) & !empty($data["directorName"]) & !empty($data["rating"]) & empty($data["genres"])) {
            // Title, director and rating
            $query = "";

        } else if (!empty($data["title"]) & !empty($data["directorName"]) & empty($data["rating"]) & !empty($data["genres"])) {
            // Title, director and genres
            $query = "";

        } else if (!empty($data["title"]) & empty($data["directorName"]) & !empty($data["rating"]) & !empty($data["genres"])) {
            // Title, rating and genres
            $query = "";

        } else if (empty($data["title"]) & !empty($data["directorName"]) & !empty($data["rating"]) & !empty($data["genres"])) {
            // Director, rating, genres
            $query = "";

        } else {
            // title, director, rating, genres
            $query = "";
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

    function showMovies() {
        // Get which movies do we have to show

        // Fetch database

        // save it to $listOfMovies

        // Parse Movies
        require 'helpers/parseMovieToJson.php'; 
        $parsedData = parseToJson($listOfMovies);


        // Show parsed Movies
        echo $parsedData;
    }