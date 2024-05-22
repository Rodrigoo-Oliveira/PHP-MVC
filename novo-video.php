<?php

$pdo = new PDO(dsn:'mysql:host=localhost;dbname=aluraplay', username:'root', password: '123456');

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /?sucesso=0');
    exit();
}

$repository = new \Alura\Mvc\Repository\VideoRepository($pdo);

if ($repository->add(new \Alura\Mvc\Entity\Video($url, $titulo)) === false) {
    header(header:'Location: /?sucesso=0');
} else {
    header(header:'Location: /?sucesso=1');
}


