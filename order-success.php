<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success - TMA</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/order-success.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="success-container">
  <h1>Thank you for your order!</h1>
  <p>Your order has been successfully placed.</p>

  <div class="success-buttons">
    <a href="index.php" class="home-btn">Continue Shopping</a>
    <a href="orders.php" class="orders-btn">View Your Orders</a>
  </div>
</div>

</body>
</html>
