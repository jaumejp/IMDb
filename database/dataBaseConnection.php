<?php
    // connection to BBDD:
    $host = "localhost";
    $database = "imdb";
    $user = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        
    } catch(PDOExeption $e) {
        die("PDO Connection error: " . $e->getMessage());
    }


?>