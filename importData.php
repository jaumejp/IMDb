<?php

    require 'dataBaseConnection.php';
    require 'Movie.php';
    require 'Director.php';

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
        // s'ha de fer un select de la id de la pelicula i després fer un 
        // select del no del genere que té aquest id. 
        $statement = $conn->prepare("SELECT url FROM screen_shots WHERE movie_id = :movie_id");
        $statement->bindParam(":movie_id", $movie['id']);
        $statement->execute();  
        $screenShots = $statement->fetchAll();

        // Add movie to list of movies:
        $listOfMovies[] = $movieAux;
        
    }




    // Import directors Table: 




    // $listOfDirectors = array();

    // while ($director = $statement->fetch()) {
        
    //     $directorAux = new Director($director["id"], $director["name"], $director["year_of_birth"]);
        
    //     $listOfDirectors[] = $directorAux;
    // }


    

    


