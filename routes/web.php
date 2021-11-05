<?php

//*Creación de rutas
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routeList) {
    $basedir = parse_url($_ENV['APP_URL'], PHP_URL_PATH);

    //Crear las rutas
    //Formato = (http_method, URI, Controller@accion)
    //*PELICULAS
    $routeList->addRoute('GET', $basedir . '/', 'Main@index');
    $routeList->addRoute('GET', $basedir . '/peliculas', 'Pelicula@showPeliculas');
    $routeList->addRoute('GET', $basedir . '/peliculas/{id:\d+}', 'Pelicula@showFicha');
    $routeList->addRoute('GET', $basedir . '/directores/{id_director:\d+}', 'Director@showFicha');
    $routeList->addRoute('GET', $basedir . '/actores/{id_actor:\d+}', 'Actor@showFicha');

    //*CRITICAS
    $routeList->addRoute('GET', $basedir . '/criticas', 'Critica@showPeliculas');
    $routeList->addRoute('GET', $basedir . '/peliculas/{id:\d+}/criticas', 'Pelicula@showCriticas');
    $routeList->addRoute('GET', $basedir . '/criticas/{id:\d+}', 'Critica@showCritica');
    $routeList->addRoute('GET', $basedir . '/peliculas/{id:\d+}/criticas/insertar', 'Critica@showInsertForm');
    $routeList->addRoute('POST', $basedir . '/peliculas/{id:\d+}/criticas', 'Critica@insertCritica');
    $routeList->addRoute('GET', $basedir . '/peliculas/{id_pelicula:\d+}/criticas/editar/{id_critica:\d+}', 'Critica@showEditForm');
    $routeList->addRoute('PUT', $basedir . '/peliculas/{id_pelicula:\d+}/criticas/{id_critica:\d+}', 'Critica@editCritica');
    $routeList->addRoute('DELETE', $basedir . '/peliculas/{id_pelicula:\d+}/criticas/{id_critica:\d+}', 'Critica@deleteCritica');
});


//* Fetch method and URI from somewhere
$http_method = $_SERVER['REQUEST_METHOD'];

//*Controlar los métodos permitidos
$allowed_methods = ['GET', 'POST', 'PUT', 'DELETE'];
$http_method = strtoupper($_POST['_method']??
$_SERVER['REQUEST_METHOD']);
if(!in_array($http_method, $allowed_methods)) { //Si se usa un método NO permitido, se cambiará a GET
    $http_method = 'GET';
}

$uri = $_SERVER['REQUEST_URI'];

//* Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);


//*Acciones a realizar si la ruta es encontrada o no y si el método es válido o no
$routeInfo = $dispatcher->dispatch($http_method, $uri);
//$routeInfo[0] = Si la ruta es encontrada y si el método es válido o no.
//$routeInfo[1] = Almacena la accion a ejecutar (3 argumento del .addRoute()).
//$routeInfo[2] = Variables de las rutas.

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $controllerName = '\\controllers\\'.'Main';
        $action = 'error_404';
        $controller = new $controllerName($templates);
        $controller->$action();
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
        
    case FastRoute\Dispatcher::FOUND:
        $action = $routeInfo[1];
        $actionParts = explode('@', $action);
        $controllerName = "\\app\\controllers\\" . ucfirst($actionParts[0]);
        $action = $actionParts[1];

        $controller = new $controllerName($templates);
        $vars = $routeInfo[2];
        $controller->$action($vars);
        break;
}
