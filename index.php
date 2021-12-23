<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products','root','787878');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$statment = $pdo->prepare('SELECT * FROM products ORDER BY create_date ');
$statment ->execute();
$products = $statment->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Products</h1>
    <table class="table">

  <thead>
  <p>
            <a href="create.php" class="btn btn-success">Create</a>
        </p>
    <tr>
      <th scope="col">#</th>
      <th scope="col">title</th>
      <th scope="col">price</th>
      <th scope="col">Create data</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($products as $i => $product):?>
    <tr>
      <th scope="row"><?php echo $i+1  ?></th>
      <td><?php echo $product['title'] ?></td>
      <td><?php echo $product['price'] ?></td>
      <td><?php echo $product['create_date'] ?></td>
      <td>
      <button type="button" class="btn btn-primary btn-sm">Edit</button>
      <button type="button" class="btn btn-danger btn-sm">Delete</button>
      </td>
    </tr>
<?php endforeach;?>

</tbody>
</table>
</body>
</html>