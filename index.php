<?php
            
    // require 'importData.php'; 
    
    // require 'index.view.php';

    class Router
    { 
        protected $routes = [];
        
        public function define($routes)
        {
            $this->routes = $routes;
        }

        public static function load($file) {
            $router = new static;

            require $file;

            return $router;
        }
    
        public function direct($uri)
        {
            if (array_key_exists($uri, $this->routes)) {
                return $this->routes[$uri];
            }
    
            throw new Exception('No route defined for this URI.');
        }
    }
    
    $router = new Router;

    $routes = [
        '' => 'home.php',
        'api/movies' => 'showJsonMovies.php',
        'notFound' => 'notFound.php',
        'form' => 'form.php',
        'names' => 'add-name.php',
        'importData' => 'importData.php',
    ];
    
    $router->define($routes);

    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    //$uri = trim($_SERVER['REQUEST_URI'], '/');
    
    require $router->direct($uri);
