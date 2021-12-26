<?php

require_once "dataBase.php";
include_once '../views/header.php';

$search = $_GET['search'] ?? '' ;

if($search){

$statment = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date ');
$statment->bindValue(':title',"%$search%");

}else{
  $statment = $pdo->prepare('SELECT * FROM products ORDER BY create_date ');
}
$statment ->execute();
$products = $statment->fetchAll(PDO::FETCH_ASSOC);

?>
    <h1>Products</h1>
      <p>
            <a href="../create.php" class="btn btn-success">Create</a>
      </p>
<form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search for product" name="search" value="<?php echo $search ?>">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
  </div>
</form>


    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">image</th>
      <th scope="col">title</th>
      <th scope="col">price</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($products as $i => $product):?>
    <tr>
      <th scope="row"><?php echo $i+1  ?></th>
      <td>
                <?php if ($product['image']): ?>
                    <img src="/<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>" class="product-img">
                <?php endif; ?>
            </td>
      <td><?php echo $product['title'] ?></td>
      <td><?php echo $product['price'] ?></td>
      <td>
      <a href="../update.php?id=<?php echo $product['id'] ?>" type="button" class="btn btn-primary btn-sm">Edit</a>
<form method="POST" action="../delete.php" style="display:inline-block"> 
  <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>
      </td>
    </tr>
<?php endforeach;?>

</tbody>
</table>
</body>
</html>
