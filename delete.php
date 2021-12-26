<?php

require_once "./public/dataBase.php";

$id = $_POST['id'] ?? null;

if(!$id){
    header('Location: ./public/index.php');
    exit;
}

$statment = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statment->bindValue(':id',$id);
$statment->execute();

header('Location: ./public/index.php');
?>