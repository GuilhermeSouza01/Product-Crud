<?php

require_once "database.php";
require_once "functions.php";

$errors = [];

$title = '';
$description = '';
$price = '';
$product = [
    'image' => '',
];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:S');


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
        VALUES (:title, :image, :description, :price, :date) ");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);
        $statement->execute();
        header('Location: index.php');
    }
}

?>


<?php include_once "views/partials/header.php" ?>
<p>
    <a href="index.php" class="btn btn-secondary">Go back to the Products</a>
</p>

<h1>Create new Product</h1>
<?php include_once "views/products/form.php" ?>
</body>

</html>