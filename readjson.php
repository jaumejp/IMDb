<?php
    // Connexió amb la BBDD:
    $host = "localhost";
    $database = "intolerances";
    $user = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        
    } catch(PDOExeption $e) {
        die("PDO Connection error: " . $e->getMessage());
    }

    // Delete all from BBDD: To prevent the accumulation of data in the BBDD:
    $conn->query("DELETE from intolerances");

    // See info form BBDD: (Nothing) but If we hard-code someting we'll see it intolerance invent 1.
    $contacts = $conn->query("SELECT * FROM intolerances");

    foreach($contacts as $contact) {
        echo $contact["intolerance_name"] . "<br>";
    }

    // Get data from JSON:
    $json_data = file_get_contents("intolerances.json");
    $intolerances = json_decode($json_data, JSON_OBJECT_AS_ARRAY);
    
    // See content from JSON: 
    //print($intolerances[0]["name"]);
    foreach($intolerances as $intolerance) {
        print($intolerance["name"]);
        echo "<br/>";
    }
    
    // Posar els valors a la BBDD:
    $prova = "invent 2"; 
    $statement = $conn->prepare("INSERT INTO intolerances (intolerance_name) VALUES (:valor);");
    // Check data an put it to statement (Això serà pels JSON.)
    $statement->bindParam(":valor", $prova);
    $statement->execute();

    // Posar els valors del JSON a la BBDD:
    $statement = $conn->prepare("INSERT INTO intolerances (intolerance_name) VALUES (:valor);");
    foreach($intolerances as $intolerance) {
        $statement->bindParam(":valor", $intolerance["name"]);
        $statement->execute();      
    }

    echo  "<br/>" . "ALL FROM DATABASE:" . "<br/>"; 

    // Once added, see values of BBDD again:
    $contacts = $conn->query("SELECT * FROM intolerances");
    foreach($contacts as $contact) {
        print($contact["intolerance_name"]);
        echo "<br/>";
    }