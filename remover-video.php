<?php

$pdo = new PDO(dsn:'mysql:host=localhost;dbname=aluraplay', username:'root', password: 'R@d248613');

$id = $_GET['id'];
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);

if ($statement->execute() === false) {
    header("Location: /index.php?sucesso=0");
} else {
    header('Location: /index.php?sucesso=1');
}

?>