<?php
    class GenreRepository 
    {
        public $conn;
    
        public function __construct($databaseConnector) {
            $this->conn = $databaseConnector;
        }

        function getGenres() {

            // List of Genres
    
            $statement = $this->conn->prepare("SELECT * FROM genres"); 
            $statement->execute(); 
    
            $listOfGenres = array();
    
            $genres = $statement->fetchAll();
    
            // while ($movie = $statement->fetch()) {
            foreach ($genres as $genre) { 
                $listOfGenres[] = $genre["genere"];
            }   
    
            return $listOfGenres;
        }
    
    }