<?php

require_once "./public/functions.php";
require_once "./public/dataBase.php";

$errors = [];

$title = '';
$description = '';
$price = '';
$product= [
  'image' => ''
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once './product/validate.php' ;
    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        $statement->execute();
        header('Location: ./public/index.php');
    }
}

?>
      <?php include_once './views/header.php' ?>
      <p>
    <a href="./public/index.php" class="back_btn"> < Back to products</a>
</p>
      <div class="product-form">  <h1>Create new product</h1>

      <?php include_once './product/form.php' ?>
</body>
</html>