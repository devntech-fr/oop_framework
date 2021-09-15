<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function byeController(Request $request): Response
{
    $response = render_template($request);
    $response->headers->set('Content-Type', 'text/html');
    return $response;
}

