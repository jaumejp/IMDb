<?php
    // Connexió amb la BBDD:
    $host = "localhost";
    $database = "imdb";
    $user = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        
    } catch(PDOExeption $e) {
        die("PDO Connection error: " . $e->getMessage());
    }

    // Delete all from BBDD: To prevent the accumulation of data in the BBDD:
    $conn->query("TRUNCATE TABLE genres_of_movies");
    $conn->query("DELETE FROM genres");
    $conn->query("DELETE FROM movies");
    $conn->query("DELETE FROM directors");
    $conn->query("DELETE FROM screen_shots");
    $conn->query("DELETE FROM directors");
  
    // Get data from JSON:
    // Directors
    $json_data = file_get_contents("directors.json");
    $directors = json_decode($json_data, true);
    
    // Genres
    $json_data = file_get_contents("genres.json");
    $genres = json_decode($json_data, JSON_OBJECT_AS_ARRAY);

    // Movies
    $json_data = file_get_contents("movies.json");
    $movies = json_decode($json_data, JSON_OBJECT_AS_ARRAY);

    // Add values from JSON to BBDD:
    // Directors
    $statement = $conn->prepare("INSERT INTO directors (name, year_of_birth) VALUES (:director_name, :year_of_birth)");
    foreach($directors as $director) {
        $statement->bindParam(":director_name", $director["name"]);
        $statement->bindParam(":year_of_birth", $director["birthdate"]);
        $statement->execute();      
    }

    // Genres
    $statement = $conn->prepare("INSERT INTO genres (genere) VALUES (:genere)");
    foreach($genres as $genre) {
        $statement->bindParam(":genere", $genre["name"]);
        $statement->execute();      
    }


    // Movies
    $statementInsert = $conn->prepare("INSERT INTO movies (title, description, rating, cover_image, director_id, summary) VALUES (:movie_title, :movie_description, :rating, :cover_image, :director_id, :summary)");

    foreach($movies as $movie) {

        $statement = $conn->prepare("SELECT id FROM directors WHERE name = :movie_director");
        $statement->bindParam(":movie_director", $movie['director']);
        $statement->execute();  
        $director = $statement->fetch();
        $directorId = $director['id'];
        //var_dump($directorId);

        $statementInsert->bindParam(":movie_title", $movie["title"]);
        $statementInsert->bindParam(":movie_description", $movie["description"]);
        $statementInsert->bindParam(":rating", $movie["score"]);
        $statementInsert->bindParam(":cover_image", $movie["cover"]);
        $statementInsert->bindParam(":director_id", $directorId);
        $statementInsert->bindParam(":summary", $movie["resume"]);

        $statementInsert->execute();  
             
    }

    // Screen Shots: 
    $sql = "INSERT INTO screen_shots (url, movie_id) VALUES (:screen_shot_url, :movie_id)";
    $insertStatement = $conn->prepare($sql);    

    // For every movie add every screen shot and movie id
    foreach($movies as $movie) {

        // Screen Shots of the movie: 
        $movieScreenShots = $movie["screenshots"];
        // Movie id: 
        $statement = $conn->prepare("SELECT id FROM movies WHERE title = :movie_title");
        $statement->bindParam(":movie_title", $movie["title"]);
        $statement->execute();  
        $movie = $statement->fetch();
        $movieId = $movie['id'];

        // Add all the screen shots of the array
        foreach($movieScreenShots as $screenShot) {
            $data = [
                'screen_shot_url' => $screenShot,
                'movie_id' => $movieId,
            ];

            $insertStatement->execute($data);
        }
    }

    // Genres of movies:
    $sql = "INSERT INTO genres_of_movies (movie_id, genre_id) VALUES (:movie_id, :genre_id)";
    $insertStatement = $conn->prepare($sql);    

    // For all the movies iterate over all the genres: 
    foreach($movies as $movie) {
        // Get the array of genres: 
        $listOfGenre = $movie["genres"];
        foreach($listOfGenre as $genere) {
            // Get genre id: 
            $statement = $conn->prepare("SELECT id FROM genres WHERE genere = :genere");
            $statement->bindParam(":genere", $genere);
            $statement->execute();  
            $genereObjFromDB = $statement->fetch();
            $genereId = $genereObjFromDB['id'];

            // Get movie id: 
            $statement = $conn->prepare("SELECT id FROM movies WHERE title = :movie_title");
            $statement->bindParam(":movie_title", $movie["title"]);
            $statement->execute();  
            $movieObjFromDB = $statement->fetch();
            $movieId = $movieObjFromDB['id'];
            
            // Insert data to generes_of_movies table:
            $data = [
                'movie_id' => $movieId,
                'genre_id' => $genereId,
            ];
            
            $insertStatement->execute($data);
        }
    }
    
    
    

