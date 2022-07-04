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

    $router->get('', 'Controllers/Movies/IndexController.php');

    $router->post('', 'Controllers/Movies/IndexController.php');

    $router->get('movies/create', 'Controllers/Movies/CreateController.php');

    $router->post('movies/store', 'Controllers/Movies/StoreController.php');

    $router->get('movies/edit', 'Controllers/Movies/EditController.php');

    $router->post('movies/update', 'Controllers/Movies/UpdateController.php');

    $router->get('movies/delete', 'Controllers/Movies/DeleteController.php');

    $router->get('movies/show', 'Controllers/Movies/ShowController.php');

    $router->get('api/movies', 'Controllers/API/Movies/IndexController.php');

    //

    $router->get('notFound', 'views/notFound.view.php');

    $router->get('loadDatabase', 'database/loadDatabaseFromJson.php');