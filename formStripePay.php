<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require ('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

$app = new \Slim\App(new \Slim\Psr7\Factory\ResponseFactory());

$token = null;

$app->get('/create-checkout-session', function(Request $request, Response $response){
	$number = $_GET['cardNumber'];
	$token = \Stripe\Token::create(array(
	'card' => array(
		'number' => $_GET['cardNumber'],
		'exp_month' => $_GET['cardMonth'],
		'exp_year' => $_GET['cardYear'],
		'cvc' => $_GET['cardCVC'],
	)));
	echo "$token";

//	$response->getBody()->write();

	return $response;
});

$app->run();

?>
