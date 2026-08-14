<?php
session_start();

// Check if product_id is sent
if (isset($_POST['product_id'])) {
  $product_id = intval($_POST['product_id']);

  // If product exists in cart, remove it
  if (isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
  }
}

// After removing, redirect back to cart page
header("Location: cart.php");
exit();
?>
