<?php
    class DirectorsRepository 
    {
        public $conn;
    
        public function __construct($databaseConnector) {
            $this->conn = $databaseConnector;
        }

        function getDirectors() {

            // List of directors: 
            $statement = $this->conn->prepare("SELECT * FROM directors"); 
            $statement->execute(); 
    
            // Generate list of directors:
            $listOfDirectors = array();
    
            $directors = $statement->fetchAll();
    
            // while ($movie = $statement->fetch()) {
            foreach ($directors as $director) { 
                $listOfDirectors[] = $director["name"];
            }
    
            return $listOfDirectors;
        }
    
    }