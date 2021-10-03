<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require ('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

$app = new \Slim\App(new \Slim\Psr7\Factory\ResponseFactory());

$token = null;

$app->post('/create-checkout-session', function(Request $request, Response $response){
	$number = $_POST['cardNumber'];
	$token = \Stripe\Token::create(array(
	'card' => array(
		'number' => $_POST['cardNumber'],
		'exp_month' => $_POST['cardMonth'],
		'exp_year' => $_POST['cardYear'],
		'cvc' => $_POST['cardCVC'],
	)));
	echo "$token";

	try{
	$charge = \Stripe\Charge::create(array(
		"amount" => $_POST['amountStripe'],
		"currency" => "usd",
		"source" => $token,
	));
	}catch(\Stripe\Error\Card $err){
		echo($err);
	}

	return $response;
});

$app->run();

?>
