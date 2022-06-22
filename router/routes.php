<?php

    // $routes = [
    //         '' => 'controller/homeController.php',
    //         'api/movies' => 'controller/showJsonMovies.php',
    //         'notFound' => 'views/notFound.view.php',
    //         'form' => 'views/form.view.php',
    //         'addMovie' => 'controller/addMovieController.php',
    //         'importData' => 'controller/importData.php',
    //         'readjson' => 'controller/readjson.php',

    //     ]; 

    // $router->define($routes);

    $router->get('', 'controller/homeController.php');

    $router->get('api/movies', 'controller/showJsonMovies.php');

    $router->get('notFound', 'views/notFound.view.php');

    $router->get('movies/create', 'views/addMovieForm.view.php');

    $router->post('api/movies', 'controller/addMovieController.php'); 

    $router->get('importData', 'controller/importData.php');

    $router->get('loadDatabase', 'database/loadDatabaseFromJson.php');

    $router->get('movie', 'views/movie.view.php');

    $router->get('movie/delete', 'controller/deleteMovieController.php');

    $router->get('movies/search', 'views/searchMovieForm.php');
