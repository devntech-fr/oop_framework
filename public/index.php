<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use App\FWKernel;

$request = Request::createFromGlobals();

$routes = include __DIR__."/../src/routes.php";

$context = new Routing\RequestContext();

$context->fromRequest($request);

$matcher = new Routing\Matcher\UrlMatcher($routes,$context);

$handler = new FWKernel($matcher);

$response = $handler->handle($request);

$response->send();
