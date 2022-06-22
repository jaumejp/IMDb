<?php
            
    // require 'routes/Router.php';
    
    // $router = new Router;

    // require 'routes/routes.php';
    
    // $router->define($routes);

    // $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    // require $router->direct($uri);

    

    require 'router/Router.php';

    require 'router/Request.php';
    
    $router = new Router;

    require 'router/routes.php';
    
    $router = Router::load('routes.php');
    
    require $router->direct(Request::uri(), Request::method());
