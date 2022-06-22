<?php

function fetchGenres() {

    require 'database/dataBaseConnection.php';

    // List of Genres

    $statement = $conn->prepare("SELECT * FROM genres"); 
    $statement->execute(); 

    $listOfGenres = array();

    $genres = $statement->fetchAll();

    // while ($movie = $statement->fetch()) {
    foreach ($genres as $genre) { 
        $listOfGenres[] = $genre["genere"];
    }   

    return $listOfGenres;
}