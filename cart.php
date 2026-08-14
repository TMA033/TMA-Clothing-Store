<?php
session_start();

// If user logged in, get their name
if (isset($_SESSION['user_id'])) {
  $conn = new mysqli("localhost", "root", "root", "user_registration");

  if (!$conn->connect_error) {
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
      $userDisplayName = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
    }

    $stmt->close();
    $conn->close();
  }
}

// Start's cart session if not already
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart - TMA</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/cart.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<h1 class="cart-title">Cart</h1>

<div class="cart-container">

<?php if (!empty($_SESSION['cart'])): ?>
  <?php foreach ($_SESSION['cart'] as $product_id => $item): 
    $itemTotal = $item['price'] * $item['quantity'];
    $totalPrice += $itemTotal;
  ?>
  <div class="cart-item">
    <div class="cart-header">
      <p><strong>Delivery:</strong> <?php echo htmlspecialchars($item['delivery_date']); ?></p>
      <p><strong>Total:</strong> $<?php echo number_format($itemTotal, 2); ?></p>
      <p><strong>Delivering to:</strong> <?php echo isset($userDisplayName) ? $userDisplayName : 'Guest User'; ?></p>
    </div>

    <div class="cart-item-body">
      <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" class="cart-item-image">

      <div class="cart-item-info">
        <h2 class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></h2>

        <div class="cart-quantity">
          <form action="update-cart.php" method="POST" class="update-quantity-form">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
            <button type="submit" class="update-btn">Update</button>
          </form>
        </div>
      </div>

      <form action="remove-from-cart.php" method="POST" class="remove-form">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <button type="submit" class="remove-btn">Remove</button>
      </form>
    </div>
  </div>
  <?php endforeach; ?>

<?php else: ?>
  <p>Your cart is empty.</p>
<?php endif; ?>

</div>

<?php if (!empty($_SESSION['cart'])): ?>
<div class="cart-footer">
  <p class="subtotal-text">Subtotal: <strong>$<?php echo number_format($totalPrice, 2); ?></strong></p>

  <?php if (isset($_SESSION['user_id'])): ?>
    <a href="checkout.php" class="checkout-btn">Proceed To Checkout</a>
  <?php else: ?>
    <a href="login.php?redirect=cart.php" class="checkout-btn">Log in to Checkout</a>
  <?php endif; ?>
</div>
<?php endif; ?>

</body>
</html>
