<?php
session_start();

// Must be logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

// Must have items in cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
  header('Location: cart.php');
  exit();
}

$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
  $totalPrice += $item['price'] * $item['quantity'];
}

$taxRate = 0.06; // 6% tax
$taxAmount = $totalPrice * $taxRate;
$finalTotal = $totalPrice + $taxAmount;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - TMA</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/cart.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<h1 class="cart-title">Checkout</h1>

<div class="checkout-main">

  <!-- Left side: cart items -->
  <div class="cart-items-container">
    <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
      <div class="cart-item">
        <div class="cart-header">
          <p><strong>Delivery:</strong> <?php echo htmlspecialchars($item['delivery_date']); ?></p>
          <p><strong>Total:</strong> $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
          <p><strong>Delivering to:</strong> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Your Address'); ?></p>
        </div>

        <div class="cart-item-body">
          <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" class="cart-item-image">
          <div class="cart-item-info">
            <h2 class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></h2>
            <div class="cart-quantity">
              <p>Quantity: <?php echo $item['quantity']; ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Right side: order summary -->
  <div class="order-summary">
    <h2>Order Summary</h2>
    <div class="summary-line">
      <span>Subtotal:</span>
      <span>$<?php echo number_format($totalPrice, 2); ?></span>
    </div>
    <div class="summary-line">
      <span>Shipping:</span>
      <span>Free</span>
    </div>
    <div class="summary-line">
      <span>Tax (6%):</span>
      <span>$<?php echo number_format($taxAmount, 2); ?></span>
    </div>
    <div class="summary-line total-line">
      <span>Total:</span>
      <span>$<?php echo number_format($finalTotal, 2); ?></span>
    </div>

    <form action="place-order.php" method="POST" style="margin-top: 20px;">
      <input type="hidden" name="final_total" value="<?php echo number_format($finalTotal, 2, '.', ''); ?>">
      <button type="submit" class="checkout-btn">Place your order</button>
    </form>
  </div>

</div>

<hr class="checkout-divider">

</body>
</html>
