<?php
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('home', new Routing\Route('/', [
        '_controller' => 'defaultController',
    ])
);
$routes->add('hello', new Routing\Route('/hello/{name}', [
        '_controller' => 'defaultController',
        'name' => 'Chokhna'
    ])
);
$routes->add('bye', new Routing\Route('/bye', [
        '_controller' => 'defaultController'
        ])
);
return $routes;
