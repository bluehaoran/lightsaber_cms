<?php


require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config.php';
require_oncE __DIR__.'/functions.php';

//-------------------------------------

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Logger;

//Symfony's ErrorHandler converts Errors to Exceptions, which can then be caught.
Symfony\Component\HttpKernel\Debug\ErrorHandler::register();


// ===========================
// Lets begin!
session_start();
$app = new Silex\Application();
$app['db'] = function() {
		$pdo = new \PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

		//Report errors as an exception.
		$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$db = new \NotORM($pdo);
		return $db;
};



$app->get('/.*favicon.ico/', function() {
		    return $app->sendFile(MAIN_WEBSITE_PATH . 'favicon.ico');
});

//Stream Images Files
$app->get('{path}/{filename}', 'CTV\AssetController::serveImage')
		->assert('path', '[\w\-\._/]+')
		->assert('filename', '[A-Za-z0-9\-\._/]+\.(jpg|jpeg|png|gif)/?');

//Render CSS files
$app->get('{path}/{filename}', 'CTV\AssetController::serveCSS')
		->assert('path', '[\w\-\._/]+')
		->assert('filename', '[\w\-]+\.css(\/)?');

//Render Javascript files
$app->get('{path}/{filename}', 'CTV\AssetController::serveJavascript')
		->assert('path', '[\w\-\._/]+')
		->assert('filename', '[\w\-]+\.js/?');


