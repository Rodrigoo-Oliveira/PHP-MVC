<?php

$pdo = new PDO(dsn:'mysql:host=localhost;dbname=aluraplay', username:'root', password: 'R@d248613');

$sql = 'INSERT INTO videos (url, title) VALUES (?,?)';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $_POST['url']);
$statement->bindValue(2, $_POST['titulo']);

if ($statement->execute() === false) {
    header("Location: /index.php?sucesso=0");
} else {
    header('Location: /index.php?sucesso=1');
}

?>