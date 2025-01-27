<?php
session_start();

// Sample product list
$products = [
    1 => ['name' => 'Amazon Gift Card', 'price' => 50],
    2 => ['name' => 'Apple Gift Card', 'price' => 100],
    3 => ['name' => 'Google Play Gift Card', 'price' => 75]
];

// Check if add to cart button was clicked
if (isset($_GET['add_to_cart'])) {
    $productId = $_GET['add_to_cart'];
    $quantity = 1;  // For simplicity, default quantity is 1

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'name' => $products[$productId]['name'],
            'price' => $products[$productId]['price'],
            'quantity' => $quantity
        ];
    }

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Card Shop</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { display: flex; flex-wrap: wrap; justify-content: center; }
        .product { border: 1px solid #ddd; padding: 20px; margin: 10px; width: 200px; text-align: center; }
        .button { background-color: #4CAF50; color: white; padding: 10px; text-decoration: none; display: inline-block; border-radius: 5px; cursor: pointer; }
        .button:hover { background-color: #45a049; }
    </style>
</head>
<body>

    <header>
        <h1>Welcome to the Gift Card Shop</h1>
        <p>Choose a gift card and add it to your cart</p>
        <a href="cart.php" class="button">View Cart</a>
    </header>

    <div class="container">
        <?php foreach ($products as $id => $product) : ?>
            <div class="product">
                <h3><?php echo $product['name']; ?></h3>
                <p>$<?php echo $product['price']; ?></p>
                <a href="?add_to_cart=<?php echo $id; ?>" class="button">Add to Cart</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

