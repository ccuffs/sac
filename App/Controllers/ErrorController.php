<?php

namespace App\Controllers;

use App\Helpers\View;

class ErrorController {
    function notFound ($request, $response, $args) {
        View::render('layout/website/header');
        View::render('errors/404');
        View::render('layout/website/footer');
        return $response;
    }

    function generic ($request, $response, $args) {
        $payload = $args[0];
        View::render('errors/generic', $payload);
        return $response;
    }
}