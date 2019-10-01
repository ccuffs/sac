<?php

namespace App\Controllers;

use App\Helpers\View;

class ErrorController {
    function notFound ($request, $response, $args) {
        View::render('layout/header');
        View::render('errors/404');
        View::render('layout/footer');
        return $response;
    }
}