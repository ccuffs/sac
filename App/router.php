<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();

$customErrorHandler = function ($request, $exception, $displayErrorDetails, $logErrors, $logErrorDetails)
use ($app)
{
    $payload = [
        'message' => $exception->getMessage(),
        'trace' => $exception->getTrace(),
        'code' => $exception->getCode()
    ];
    $response = $app->getResponseFactory()->createResponse();
    if ($payload['code'] == 404) {
        \App\Controllers\ErrorController::notFound($request, $response, []);
        return $response;
    }
    
    \App\Controllers\ErrorController::generic($request, $response, [$payload]);
    return $response;
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->setBasePath(PATH_URL);

$app->get('/', 'App\Controllers\HomeController:home');

$app->get('/api/payment/', 'App\Controllers\PaymentController:apiIndex');
$app->post('/api/attending-event/update-subscription', 'App\Controllers\AttendingEventController:updateSubscription');

$app->get('/inscricao', 'App\Controllers\AuthController:subscription');
$app->get('/inscricao/aluno', 'App\Controllers\AuthController:studantLoginForm');
$app->post('/inscricao/aluno', 'App\Controllers\AuthController:studantLogin');
$app->get('/inscricao/visitante/cadastro', 'App\Controllers\AuthController:externalRegisterForm');
$app->post('/inscricao/visitante/cadastro', 'App\Controllers\AuthController:externalRegister');
$app->get('/inscricao/visitante/login', 'App\Controllers\AuthController:externalLoginForm');
$app->post('/inscricao/visitante/login', 'App\Controllers\AuthController:externalLogin');

$app->get('/logout', 'App\Controllers\AuthController:logout');
$app->get('/perfil', 'App\Controllers\AuthController:profile');
$app->post('/perfil/atualizar', 'App\Controllers\AuthController:profileUpdate');

$app->get('/admin', 'App\Controllers\HomeController:dashboard');
$app->get('/admin/permissoes', 'App\Controllers\UserController:index');
$app->post('/admin/permissoes/{id}', 'App\Controllers\UserController:update');

$app->get('/admin/palestrantes', 'App\Controllers\SpeakerController:index');
$app->get('/admin/palestrantes/create', 'App\Controllers\SpeakerController:create');
$app->post('/admin/palestrantes/create', 'App\Controllers\SpeakerController:store');
$app->get('/admin/palestrantes/{id}', 'App\Controllers\SpeakerController:show');
$app->get('/admin/palestrantes/{id}/edit', 'App\Controllers\SpeakerController:edit');
$app->post('/admin/palestrantes/{id}/edit', 'App\Controllers\SpeakerController:update');
$app->get('/admin/palestrantes/{id}/delete', 'App\Controllers\SpeakerController:delete');

$app->get('/admin/evento', 'App\Controllers\EventController:index');
$app->get('/admin/evento/create', 'App\Controllers\EventController:create');
$app->post('/admin/evento/create', 'App\Controllers\EventController:store');
$app->get('/admin/evento/{id}', 'App\Controllers\EventController:show');
$app->get('/admin/evento/{id}/edit', 'App\Controllers\EventController:edit');
$app->post('/admin/evento/{id}/edit', 'App\Controllers\EventController:update');
$app->get('/admin/evento/{id}/delete', 'App\Controllers\EventController:delete');

$app->get('/admin/campeonato', 'App\Controllers\CompetitionController:index');
$app->get('/admin/campeonato/create', 'App\Controllers\CompetitionController:create');
$app->post('/admin/campeonato/create', 'App\Controllers\CompetitionController:store');
$app->get('/admin/campeonato/{id}', 'App\Controllers\CompetitionController:show');
$app->get('/admin/campeonato/{id}/edit', 'App\Controllers\CompetitionController:edit');
$app->post('/admin/campeonato/{id}/edit', 'App\Controllers\CompetitionController:update');
$app->get('/admin/campeonato/{id}/delete', 'App\Controllers\CompetitionController:delete');

$app->get('/admin/pagamento', 'App\Controllers\PaymentController:index');
$app->post('/admin/pagamento', 'App\Controllers\PaymentController:store');
$app->get('/admin/pagamento/{id}/delete', 'App\Controllers\PaymentController:delete');

$app->get('/admin/inscricoes', 'App\Controllers\PaymentController:stats');
$app->get('/attempt/{id}', 'App\Controllers\EventController:attempt');

$app->get('/times', 'App\Controllers\TeamController:index');

// Run app
$app->run();