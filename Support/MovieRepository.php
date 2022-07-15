<?php
    class MovieRepository 
    {
        public $conn;
        public string $message;
    
        public function __construct($databaseConnector) {
            $this->conn = $databaseConnector;
        }

        public function addMovieToDatabase($title, $description, $rating, $coverImage, $resume, $directorName, $tags, $screenShotUrls) {

            $coverImageUrl = $this->getLocalImagePath($coverImage); 

            // director id
            $statement = $this->conn->prepare("SELECT id FROM directors WHERE name = :movie_director");
            $statement->bindParam(":movie_director", $directorName);
            $statement->execute();   
            $director = $statement->fetch();
            $directorId = $director["id"];
          
            // Insert movie to database:
            $statement = $this->conn->prepare("INSERT INTO movies (title, description, rating, cover_image, director_id, summary) VALUES (:title, :description, :rating, :cover_image, :director_id, :summary)");
            $statement->bindParam(":title", $title);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":rating", $rating);
            $statement->bindParam(":cover_image", $coverImageUrl);
            $statement->bindParam(":director_id", $directorId);
            $statement->bindParam(":summary", $resume);
            $statement->execute();
            $movieId = $this->conn->lastInsertId();
    
            // Insert genres of the movie to database:
            $insertStatement = $this->conn->prepare("INSERT INTO genres_of_movies (movie_id, genre_id) VALUES (:movie_id, :genre_id)");
            foreach($tags as $tag) {
                $statement = $this->conn->prepare("SELECT id FROM genres WHERE genere = :genre");
                $statement->bindParam(":genre", $tag);
                $statement->execute();  
                $genre = $statement->fetch(); 
                $gensreId = $genre["id"];
                
                // Execute insert: 
                $insertStatement->bindParam(":movie_id", $movieId);
                $insertStatement->bindParam(":genre_id", $gensreId);
                $insertStatement->execute();
            }
    
            // Insert screen shots to database: 
            $insertScreenShot = $this->conn->prepare("INSERT INTO screen_shots (url, movie_id) VALUES (:url, :movie_id)");
            for ($i = 0; $i < sizeof($screenShotUrls["name"]); $i++) {
                $screenShotName = $screenShotUrls["name"][$i];
                $tempUrl = $screenShotUrls["tmp_name"][$i];
                $screenShotUrl = $this->getLocalScreenShotPath($screenShotName, $tempUrl);
                $insertScreenShot->bindParam(":url", $screenShotUrl);
                $insertScreenShot->bindParam(":movie_id", $movieId);
                $insertScreenShot->execute();
            }
        }

        // These function generetes a local url for the image
        private function getLocalImagePath($image) {

            // Check if the image has the correct extension:
            $file_name = $image["name"];
            $temp= explode('.',$file_name);
            $extension = end($temp);
    
            // allowed file type: 
            $allowed_exs = array("jpg", "jpeg", "png");
    
            // create a unique id name for the image and move it to uploads directory:
            $newImageName = uniqid("IMG-", true).'.'.$extension;
            $imgUploadPath = 'uploads/coverImages/'.$newImageName;
            move_uploaded_file($image["tmp_name"], $imgUploadPath);

            $imgUploadPath = '../' . $imgUploadPath;
            
            return $imgUploadPath;
            
        }

        // These function generetes a local image for one screen shot
        private function getLocalScreenShotPath($screenShotName, $tempUrl) {
            $file_name = $screenShotName;
            $temp= explode('.',$file_name);
            $extension = end($temp);
    
            $newImageName = uniqid("IMG-", true).'.'.$extension;
            $imgUploadPath = 'uploads/screenShots/'.$newImageName;
            move_uploaded_file($tempUrl, $imgUploadPath);

            $imgUploadPath = '../' . $imgUploadPath;


            return $imgUploadPath;
    
        }

        public function editMovie($id, $title, $description, $rating, $coverImage, $resume, $directorName, $tags, $screenShotUrls) { 
            // var_dump($id); echo '<br><br>';
            // var_dump($title); echo '<br><br>';
            // var_dump($description); echo '<br><br>';
            // var_dump($rating); echo '<br><br>';
            // var_dump($coverImage); echo '<br><br>';
            // var_dump($resume); echo '<br><br>';
            // var_dump($directorName); echo '<br><br>';
            // var_dump($tags); echo '<br><br>';
            // var_dump($screenShotUrls); echo '<br><br>';
            // die();

            // // Update movies table: 
            // // Get director id from their name: 
            if (!empty($coverImage['name'])) {
                $coverImage = $this->getLocalImagePath($coverImage);
            }

            $statement = $this->conn->prepare("SELECT id FROM directors WHERE name = :movie_director");
            $statement->bindParam(":movie_director", $directorName);
            $statement->execute();  
            $director = $statement->fetch();
            $directorId = $director['id'];

            $query = "UPDATE movies set title = :title, description = :description, rating = :rating, cover_image = :cover_image, director_id = :director_id, summary = :summary WHERE id = :movie_id";
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":movie_id", $id);
            $statement->bindParam(":title", $title);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":rating", $rating);
            $statement->bindParam(":cover_image", $coverImage);
            $statement->bindParam(":director_id", $directorId);
            $statement->bindParam(":summary", $resume);

            $statement->execute(); 

            // Update screen shots
            $query = "DELETE FROM screen_shots WHERE movie_id = :movie_id";
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":movie_id", $id);
            $statement->execute(); 
            // Add screen shots:
            if (empty($screenShotUrls['name'][0])) {
                // old - no es necessari fer això
                foreach($screenShotUrls as $screenShot) {
                    $statement = $this->conn->prepare("INSERT INTO screen_shots (url, movie_id) VALUES (:url, :movie_id)");
                    $statement->bindParam(":url", $screenShot);
                    $statement->bindParam(":movie_id", $id);
                    $statement->execute();
                }  
            } else {
                // new
                $insertScreenShot = $this->conn->prepare("INSERT INTO screen_shots (url, movie_id) VALUES (:url, :movie_id)");
                for ($i = 0; $i < sizeof($screenShotUrls["name"]); $i++) {
                    $screenShotName = $screenShotUrls["name"][$i];
                    $tempUrl = $screenShotUrls["tmp_name"][$i];
                    $screenShotUrl = $this->getLocalScreenShotPath($screenShotName, $tempUrl);
                    $insertScreenShot->bindParam(":url", $screenShotUrl);
                    $insertScreenShot->bindParam(":movie_id", $id);
                    $insertScreenShot->execute();
                }
            }

            // Update tags. Delete all tags from these movie and add it again
            $query = "DELETE FROM genres_of_movies WHERE movie_id = :movie_id";
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":movie_id", $id);
            $statement->execute(); 

            // Get array with all genres id: 
            $genresIdList = array();
            foreach($tags as $tag) {
                $statement = $this->conn->prepare("SELECT id FROM genres WHERE genere = :genere");
                $statement->bindParam(":genere", $tag);
                $statement->execute();  
                $genere = $statement->fetch();
                $genereId = $genere['id'];
                $genresIdList[] = $genereId;
            }
            //var_dump($genresIdList); var_dump($id); die();
            // Add tags:
            $statement = $this->conn->prepare("INSERT INTO genres_of_movies (movie_id, genre_id) VALUES (:movie_id, :genre_id)");
            foreach($genresIdList as $genreId) {
                $statement->bindParam(":movie_id", $id);
                $statement->bindParam(":genre_id", $genreId);
                $statement->execute();  
            }

            

        }

        // These function deletes a movie. returns true if the execution goes correctly. False for any error.
        public function deleteMovie($id) {
            // Get title of the movie:
            //$movieTitle = $this->getMovieTitleOf($id);

            try {
                // delete screen_shots
                $statement = $this->conn->prepare("DELETE FROM screen_shots WHERE movie_id = :movie_id");
                $statement->bindParam(":movie_id", $id);
                $statement->execute(); 

                // delete genres_of_movies
                $statement = $this->conn->prepare("DELETE FROM genres_of_movies WHERE movie_id = :movie_id");
                $statement->bindParam(":movie_id", $id);
                $statement->execute();  

                // Delete movie
                $statement = $this->conn->prepare("DELETE FROM movies WHERE id = :movie_id");
                $statement->bindParam(":movie_id", $id);
                $statement->execute(); 
                
            } catch (Exception $e) {
                //$this->message = "An error occurred!";
                $this->message = "An error occurred! Movie has not been deleted";
                return false;

            }

            if ($statement->rowCount() == 1) {
                $this->message = "Movie deleted correctly";
                return true;
            } else {
                $this->message = "An error occurred! Movie has not been deleted";
                return false;
            }

            //$this->message = "<span>" . $movieTitle . "</span>" . " deleted correctly!";
        }   

        // Given the id of the movie, returns the movie title
        private function getMovieTitleOf($id) {
            $statement = $this->conn->prepare("SELECT title FROM movies WHERE id = :movie_id");
            $statement->bindParam(":movie_id", $id);
            $statement->execute();   
            $movie = $statement->fetch();
            $movieTitle = $movie["title"];

            return $movieTitle;
        }

        // Given an id of a movie, returns an array with the movie
        public function getMovieFromDirectorId($id) {
            $query = "SELECT * from movies WHERE id = :movie_id";
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":movie_id", $id);
            $statement->execute(); 
            $movie = $statement->fetchAll();
            return $movie;
        }

        // These function returns an array of query registers from database
        public function getDataFor($query) {
            $statement = $this->conn->prepare($query); 
            $statement->execute();  
            return $statement->fetchAll();
        }
    
    }