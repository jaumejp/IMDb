<?php 

    function fetchDirectors($conn) {

        // List of directors: 
        $statement = $conn->prepare("SELECT * FROM directors"); 
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

