<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function render_template(Request $request): Response
{
    // extract attributes with the shape ['_param' => 'value']
    extract($request->attributes->all(), EXTR_SKIP);
    // start view buffer
    ob_start();
    // include required view file based on route name
    include sprintf(
        __DIR__ . '/%s.php',
        $_route
    );
    // return new response
    return new Response(ob_get_clean());
}
