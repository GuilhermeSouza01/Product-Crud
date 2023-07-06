<?php

$id = $_POST['id'] ?? null;


require_once "../../database.php";


if (!$id) {
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

header("Location: index.php");
