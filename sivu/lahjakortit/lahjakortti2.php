<?php
session_start();

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    $message = "Your cart is empty.";
} else {
    $message = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: 20px auto; }
        .cart-item { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
        .cart-item p { margin: 5px 0; }
        .button { background-color: #4CAF50; color: white; padding: 10px; text-decoration: none; display: inline-block; border-radius: 5px; cursor: pointer; }
        .button:hover { background-color: #45a049; }
    </style>
</head>
<body>

    <header>
        <h1>Your Cart</h1>
        <a href="index.php" class="button">Back to Shop</a>
    </header>

    <div class="container">
        <?php if ($message) : ?>
            <p><?php echo $message; ?></p>
        <?php else : ?>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['cart'] as $item) : ?>
                <div class="cart-item">
                    <p>Name: <?php echo $item['name']; ?></p>
                    <p>Price: $<?php echo $item['price']; ?></p>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                    <p>Total: $<?php echo $item['price'] * $item['quantity']; ?></p>
                </div>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>

            <h3>Total: $<?php echo $total; ?></h3>
            <a href="checkout.php" class="button">Proceed to Checkout</a>
        <?php endif; ?>
    </div>

</body>
</html>
