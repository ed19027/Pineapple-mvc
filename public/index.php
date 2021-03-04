<?php

require_once __DIR__.'/../vendor/autoload.php';
use app\core\Application;
use app\controllers\SubsController;

$app = new Application(dirname(__DIR__));

$app->router->get('/', [SubsController::class, 'index']);
$app->router->post('/', [SubsController::class, 'store']);

$app->run();