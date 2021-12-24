<?php

require_once "functions.php";

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products','root','787878');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$description = '';
$price = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!$title) {
      $errors[] = 'product title is required';
  }
  if (!$price) {
      $errors[] = 'product price is required';
  }

    $image = $_FILES['image'] ?? null;
    $imagePath = '';

    if (!is_dir('images')) {
        mkdir('images');
    }

    if ($image && $image['tmp_name']) {
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

    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        $statement->execute();
        header('Location: index.php');
    }

}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Css-->
    <link rel="stylesheet" href="index.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Products</title>
  </head>
  <body>
      <div class="create-form">  <h1>Create new product</h1>

      <?php ?>
      <div class="alert-danger">
          <?php foreach($errors as $error): ?>
            <div><?php echo  $error?></div>
          <?php endforeach;?>

      </div>
    <form action="" method="POST" enctype="multipart/form-data">
    <button type="submit" class="btn btn-success">Submit</button>
  <div class="mb-3">
    <label>title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $title ?>"> 
  </div>
  <div class="mb-3">
    <label>price</label>
    <input type="number" step="0.1" class="form-control" name="price" value="<?php echo $price ?>">
  </div>
  <div class="mb-3">
    <label>Description</label>
    <textarea class="form-control" name="description" value="<?php echo $description ?>"></textarea>
  </div>
  <div class="mb-3">
    <label>image</label>
    <input type="file" class="form-control" name="image">
  </div>
  </div>
</form>
</div>
</body>
</html>