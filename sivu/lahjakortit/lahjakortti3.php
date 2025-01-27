<?php
session_start();

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate a checkout process (e.g., payment, order processing)
    session_unset();  // Clear the cart after checkout
    $checkoutMessage = "Thank you for your purchase! Your order has been placed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: 20px auto; text-align: center; }
        .button { background-color: #4CAF50; color: white; padding: 10px; text-decoration: none; display: inline-block; border-radius: 5px; cursor: pointer; }
        .button:hover { background-color: #45a049; }
        .checkout-form { text-align: left; }
    </style>
</head>
<body>

    <header>
        <h1>Checkout</h1>
    </header>

    <div class="container">
        <?php if (isset($checkoutMessage)) : ?>
            <p><?php echo $checkoutMessage; ?></p>
            <a href="index.php" class="button">Return to Shop</a>
        <?php else : ?>
            <h2>Order Summary</h2>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['cart'] as $item) : ?>
                <p><?php echo $item['name']; ?> - $<?php echo $item['price']; ?> x <?php echo $item['quantity']; ?> = $<?php echo $item['price'] * $item['quantity']; ?></p>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
            <h3>Total: $<?php echo $total; ?></h3>

            <h2>Enter Your Details</h2>
            <form method="POST" class="checkout-form">
                <label for="name">Full Name:</label>
                <input type="text" name="name" required><br><br>
                <label for="address">Shipping Address:</label>
                <input type="text" name="address" required><br><br>
                <button type="submit" class="button">Confirm Order</button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>
