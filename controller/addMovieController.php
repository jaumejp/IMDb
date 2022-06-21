<?php
    require 'controller/formValidationFunctions.php';
    $title = $_POST["title"];
    $resume = $_POST["resume"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];
    $directorName = $_POST["director-name"];
    $tags = $_POST["tags"];    
    $file_name = $_FILES["cover-image"]["name"];
    $temp= explode('.',$file_name);
    $extension = end($temp);

    // allowed file type: 
    $allowed_exs = array("jpg", "jpeg", "png");

    if (in_array($extension, $allowed_exs)) {
        // Crear una carpeta
        // Crear un nom de foto única
        $newImageName = uniqid("IMG-", true).'.'.$extension;
        $imgUploadPath = 'uploads/'.$newImageName;
        move_uploaded_file($_FILES["cover-image"]["tmp_name"], $imgUploadPath);
    }



    if (!inputsFilled($title, $resume, $description, $rating, $coverImage, $directorName, $tags)) {
        $error = "Please fill all the fields";

    } else if (!ratingOnRange($rating)) {
        $error = "Rating must be between 0 and 10";

    } else if (false && empty($_POST["cover_image"])) {
        $error = "Upload a valid cover image";

    } else if(!directorNameOK($directorName)) {
        $error = "Enter a valid director's name";

    } else if (!tagsOK($tags)) {
        $error = "Enter a valid genres";
    } else {
    
        // Add data to BBDD
        $statement = $conn->prepare("INSERT INTO movies () VALUES (:title, :description, :rating, :cover_image, :director_id, :summary)");
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $title);
        $statement->bindParam(":cover_image", $title);
        $statement->bindParam(":director_id", $title);
        $statement->bindParam(":summary", $title);
        $statement->execute();
        
        // Insert a les altres taules
    }

    
    if ($error) {
        echo $error;
    }

    
    // Return to form: 





