<?php

declare(strict_types=1);

use Alura\Mvc\Controller\{
    Controller,
    DeleteVideoController,
    EditVideoController,
    Error404Controller,
    NewVideoController,
    VideoFormController,
    VideoListController
};

use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO(dsn:'mysql:host=localhost;dbname=aluraplay', username:'root', password: '123456');

$videoRepository = new VideoRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php'; // Definindo as rotas

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";

if(array_key_exists($key,$routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    $controller = new $controllerClass($videoRepository);
} else {
    $controller = new Error404Controller();
}

/** @var \Alura\Mvc\Controller\Controller $controller */
$controller->processaRequisicao();