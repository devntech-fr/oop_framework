<?php
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routes = new Routing\RouteCollection();
$routes->add('home', new Routing\Route('/'), [
    '_controller' => static function (Request $request): Response
    {
//        $request->attributes->set('foo','bar');
        $response = render_template($request);
        $response->headers->set('Content-Type','text/plain');
        return $response;
    }
]);
$routes->add('hello', new Routing\Route('/hello', [
//        'name' => 'World',
        '_controller' => static function (Request $request): Response
        {
            $request->attributes->set('name','World');
            $response = render_template($request);
            $response->headers->set('Content-Type','text/plain');
            return $response;
        }
    ])
);
$routes->add('bye', new Routing\Route('/bye'), [
    '_controller' => static function (Request $request): Response
    {
        $request->attributes->set('foo','bar');
        $response = render_template($request);
        $response->headers->set('Content-Type','text/plain');
        return $response;
    }
]);
return $routes;
