
<?php 

    require_once 'models/Movie.php';
    require_once 'models/Director.php';

    // Service no connexió bbdd, repo si, service, li passem tots els parametres que han sigut fetch per repo

    class MovieService
    {
        public $conn;
    
        public function __construct($dataConnector) {
            $this->conn = $dataConnector;
        }

        //These function recives the database registers and return an array of objects of the class Movie.
        public function parseListOfMovies($movies) {

            // Canviar que no per cada iteració del bucle es faci una select dels directors, Fer-ne un primer i després iterar a partir del array.

            // while ($movie = $statement->fetch()) {
            foreach ($movies as $movie) {

                // Create aux movie to push it to the array:
                $movieAux = new Movie($movie["id"], $movie["title"], $movie["description"], $movie["rating"], $movie["cover_image"], $movie["summary"]);
                
                // Create director object
                $statement = $this->conn->prepare("SELECT * FROM directors WHERE id = :movie_director");
                $statement->bindParam(":movie_director", $movie['director_id']);
                $statement->execute();  
                $director = $statement->fetch();        
                $directorAux = new Director($director['id'] ?? '', $director['name'] ?? '', $director['year_of_birth'] ?? '');

                // Put the object director to the Movie: 
                $movieAux->setDirector($directorAux);

                // Put the screen_shots to the Movie: 
                //var_dump($movie);
                $statement = $this->conn->prepare("SELECT url FROM screen_shots WHERE movie_id = :movie_id");
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
                $statement = $this->conn->prepare("SELECT genere FROM genres WHERE id in (SELECT genre_id FROM genres_of_movies WHERE movie_id = :movie_id)");
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

        // Given a list of objects movie, returns the corresponent JSON
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
    

    }