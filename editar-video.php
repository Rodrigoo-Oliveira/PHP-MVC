<?php

$pdo = new PDO(dsn:'mysql:host=localhost;dbname=aluraplay', username:'root', password: '123456');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false && $id !== null) {
    header('Location: /?sucesso=0');
    exit();
}

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

$sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
$statement = $pdo->prepare($sql);
$statement->bindValue(':url', $url);
$statement->bindValue(':title', $titulo);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$video = new \Alura\Mvc\Entity\Video($url, $titulo);
$video->setId($id);

$repository = new \Alura\Mvc\Repository\VideoRepository($pdo);
$repository->update($video);

if ($statement->execute() === false) {
    header(header:'Location: /?sucesso=0');
} else {
    header(header:'Location: /?sucesso=1');
}
