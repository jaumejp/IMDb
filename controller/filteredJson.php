<?php
    require 'showJsonMovies.php';

    //var_dump("hola"); die();

    //?movie=1&director=2&rating=3;

    // filters: 
    // text: movie name and resume or tags

    // Director

    // Rating

    // var_dump($_GET["id"]);
    // echo '<br><br>';
    // var_dump($_GET["name"]); 
    // die();

    // Case 1: Any parameters:
    if (empty($_GET["title"]) && empty($_GET["director-name"]) && !isset($_GET["rating"])) {
        showAllMovies();
    } else {
        var_dump("adeu");
    }
die();

    if (!allInputsFilled($_POST["title"], $_POST["resume"], $_POST["description"])) {
        $error = "Please fill all the fields";

    } else if (!ratingOK($_POST["rating"])) {
        $error = "Rating must be between 0 and 10";

    } else if (!imageOK($_FILES["cover-image"])) {
        $error = "Upload a valid cover image";

    } else if(!directorNameOK($_POST["director-name"], $listOfDirectors)) {
        $error = "Enter a valid director's name";

    } else if(!isset($_POST["tags"])) {
        $error = "Enter at least one tag";

    } else if (!tagsOK($_POST["tags"], $listOfGenres)) {
        $error = "Enter a valid genres";

    } else if (!screenShotsOK($_FILES["screen_shots"])) {
        $error = "Upload valid screen shots";
    } else {
        // Add data to BBDD
        var_dump("all files are OK!");
    }

