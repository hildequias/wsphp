<?php
session_start();
date_default_timezone_set("Brazil/East");

require 'config.php';
require 'DB.php';

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'debug' => true
        ));

$app->contentType("application/json");

$app->error(function ( Exception $e = null) use ($app) {
	echo '{"error":{"text":"'. $e->getMessage() .'"}}';
});

//GET may have a parameter in the URL
$app->get('/:controller/:action(/:parameter)', function ($controller, $action, $parameter = null) use($app) {
		
	include_once "model/{$controller}.php";
	$classe = new $controller();
	$retorno = call_user_func_array(array($classe, "get_" . $action), array($parameter));
	
	echo '{"result":' . json_encode($retorno) . '}';
});

//POST has no parameters in the URL, but on request
$app->post('/:controller/:action', function ($controller, $action) use ($app) {
		
	$request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
	include_once "model/{$controller}.php";
	$classe = new $controller();
	$retorno = call_user_func_array(array($classe, "post_" . $action), array($request));
	
	echo '{"result":' . json_encode($retorno) . '}';
});

$app->run();