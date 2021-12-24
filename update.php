<?php

require_once "functions.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products','root','787878');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


$title = $product['title'];
$description = $product['description'];
$price = $product['price'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    if (empty($errors)) {
        $statement = $pdo->prepare("UPDATE products SET title = :title, 
                                        image = :image, 
                                        description = :description, 
                                        price = :price WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);

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
<p>
    <a href="index.php" class="back_btn"> < Back to products</a>
</p>
<div class="product-form">
<h1>Update Product: <b><?php echo $product['title'] ?></b></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" >
    <?php if ($product['image']): ?>
        <img src="<?php echo $product['image'] ?>" class="product-img">
    <?php endif; ?>
    <div class="form-group">
        <label>Product Image</label><br>
        <input type="file" name="image">
    </div>
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

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


<!-- <form action="" method="POST" enctype="multipart/form-data">
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
  </div>
</form> -->

</body>
</html>