<?php

require 'database/dataBaseConnection.php';
$conn = createConectionToDB();

require 'database/fetchDirectors.php'; 
$listOfDirectors = fetchDirectors($conn);

require 'views/searchMovieForm.php';