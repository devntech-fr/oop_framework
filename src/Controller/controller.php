<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function defaultController(Request $request): Response
{
    // include view function
    include __DIR__."/../View/views.php";
    // get response from render_template function
    $response = render_template($request);
    // add content-type header
    $response->headers->set('Content-Type','text/html');
    // return response
    return $response;
}
