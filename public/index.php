<?php 
	require_once dirname(__FILE__).'/../inc/globals.php';
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	require __DIR__ . '/../vendor/autoload.php';

	$app = AppFactory::create();

	$app->addRoutingMiddleware();
	$errorMiddleware = $app->addErrorMiddleware(true, true, true);

	$app->setBasePath('/sac');

	$app->get('/', 'Controllers\HomeController:home');

	$app->get('/api/payment/', 'Controllers\PaymentController:apiIndex');
	$app->post('/api/attending-event/update-subscription', 'Controllers\AttendingEventController:updateSubscription');

	$app->get('/login', 'Controllers\AuthController:loginForm');
	$app->get('/inscricao', 'Controllers\AuthController:subscriptionForm');
	$app->post('/login', 'Controllers\AuthController:login');
	$app->get('/logout', 'Controllers\AuthController:logout');

	$app->get('/admin/evento', 'Controllers\EventController:adminIndex');
	$app->post('/admin/evento', 'Controllers\EventController:create');
	$app->get('/admin/campeonato', 'Controllers\CompetitionController:index');
	$app->post('/admin/campeonato', 'Controllers\CompetitionController:create');
	$app->get('/admin/inscricoes', 'Controllers\SubscribeController:index');
	$app->get('/admin/pagamento', 'Controllers\SubscribeController:payment');
	$app->post('/admin/pagamento', 'Controllers\SubscribeController:paymentCreate');

	$app->get('/times', 'Controllers\TeamController:index');

	// Run app
	$app->run();
?>