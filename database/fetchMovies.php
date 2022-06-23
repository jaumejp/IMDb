<?php

    /**
     * These function fetch the imdb database and return an array of movies.
     */
    function fetchMovies($conn) {
        require 'models/Movie.php';
        require 'models/Director.php';

        // Import Movies Table:
        // Get movies data from BBDD:
        $statement = $conn->prepare("SELECT * FROM movies"); 
        $statement->execute();  

        // Generate list of Movies:
        $listOfMovies = array();

        // fetch all movies at the same time:
        $movies = $statement->fetchAll();
        //var_dump($movies); die();

        // fetch movie by movie:

        // while ($movie = $statement->fetch()) {
        foreach ($movies as $movie) {

            // Create aux movie to push it to the array:
            $movieAux = new Movie($movie["id"], $movie["title"], $movie["description"], $movie["rating"], $movie["cover_image"], $movie["summary"]);
            
            // Create director object
            $statement = $conn->prepare("SELECT * FROM directors WHERE id = :movie_director");
            $statement->bindParam(":movie_director", $movie['director_id']);
            $statement->execute();  
            $director = $statement->fetch();        
            $directorAux = new Director($director['id'], $director['name'], $director['year_of_birth']);
            
            // Put the object director to the Movie: 
            $movieAux->setDirector($directorAux);

            // Put the screen_shots to the Movie: 
            //var_dump($movie);
            $statement = $conn->prepare("SELECT url FROM screen_shots WHERE movie_id = :movie_id");
            $statement->bindParam(":movie_id", $movie['id']);
            $statement->execute();  
            $screenShots = $statement->fetchAll(); 
            // Create array with screen shots data:
            $screnShotsArray = array();
            foreach($screenShots as $screenShot) {
                $screnShotsArray[] = $screenShot["url"];
            }
            // Add the array to the movies list: 
            $movieAux->setScreenShots($screnShotsArray);

    
            
            // Select the genres of the movie: 
            $statement = $conn->prepare("SELECT genere FROM genres WHERE id in (SELECT genre_id FROM genres_of_movies WHERE movie_id = :movie_id)");
            $statement->bindParam(":movie_id", $movie['id']);
            $statement->execute();  
            $genres = $statement->fetchAll();

            // Create array of genres and add it to the movie object:
            $genresArray = array();
            foreach($genres as $genre) {
                $genresArray[] = $genre["genere"];
            }

            $movieAux->setGenres($genresArray);

            // Add movie to list of movies:
            $listOfMovies[] = $movieAux;
            
        }

        return $listOfMovies;
    }