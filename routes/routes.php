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

    $router->get('movies/create', 'views/form.view.php');

    $router->post('api/movies', 'controller/addMovieController.php'); 

    $router->get('importData', 'controller/importData.php');

    $router->get('readjson', 'controller/readjson.php');

    $router->get('movie', 'views/movie.view.php');

    $router->get('movie/delete', 'controller/deleteMovieController.php');
