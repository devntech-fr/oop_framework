<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function render_template(Request $request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(
        __DIR__ . '/../src/View/%s.php',
        $_route
    );
    return new Response(ob_get_clean());
}

$request = Request::createFromGlobals();
$routes = include __DIR__."/../src/routes.php";

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes,$context);

try {
    // returns ['_route' => 'route_name']
    $request->attributes->add($matcher->match($request->getPathInfo()));
    var_dump($request->attributes);
    $response = call_user_func($request->attributes->get('_controller'), $request);
} catch (Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response(
        'Not Found',
        Response::HTTP_NOT_FOUND
    );
} catch (Exception $exception) {
    $response = new Response("An error occured", Response::HTTP_INTERNAL_SERVER_ERROR);
}

$response->send();
