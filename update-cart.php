<?php
session_start();

// Check if product_id and quantity were sent
if (isset($_POST['product_id'], $_POST['quantity'])) {
  $product_id = intval($_POST['product_id']);
  $quantity = intval($_POST['quantity']);

  // Check if product exists in cart
  if (isset($_SESSION['cart'][$product_id])) {
    // If quantity is at least 1, update it
    if ($quantity >= 1) {
      $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
  }
}

// After updating, redirect's user back to cart page
header("Location: cart.php");
exit();
?>
