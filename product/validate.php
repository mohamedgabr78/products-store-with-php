<?php

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];

$image = $_FILES['image'] ?? null;
$imagePath = '';

if (!is_dir('images')) {
    mkdir('images');
}

if ($image) {
    if ($product['image']) {
        unlink($product['image']);
    }
    $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
    mkdir(dirname($imagePath));
    move_uploaded_file($image['tmp_name'], $imagePath);
}

if (!$title) {
    $errors[] = 'Product title is required';
}

if (!$price) {
    $errors[] = 'Product price is required';
}