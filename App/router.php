<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->setBasePath('/sac');

$app->get('/', 'App\Controllers\HomeController:home');

$app->get('/api/payment/', 'App\Controllers\PaymentController:apiIndex');
$app->post('/api/attending-event/update-subscription', 'App\Controllers\AttendingEventController:updateSubscription');

$app->get('/login', 'App\Controllers\AuthController:loginForm');
$app->get('/inscricao', 'App\Controllers\AuthController:subscriptionForm');
$app->post('/login', 'App\Controllers\AuthController:login');
$app->get('/logout', 'App\Controllers\AuthController:logout');
$app->get('/perfil', 'App\Controllers\AuthController::profile');
$app->get('/admin/permissoes', 'App\Controllers\UserController:index');
$app->post('/admin/permissoes/{id}', 'App\Controllers\UserController:update');

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