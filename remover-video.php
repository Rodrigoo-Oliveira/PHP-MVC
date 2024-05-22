<?php

use Alura\Mvc\Repository\VideoRepository;

$pdo = new PDO(dsn:'mysql:host=localhost;dbname=aluraplay', username:'root', password: '123456');

$id = $_GET['id'];
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);

$repository = new \Alura\Mvc\Repository\VideoRepository($pdo);


if ($repository->remove($id) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}
