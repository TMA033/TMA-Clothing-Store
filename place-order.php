<?php
session_start();

$conn = new mysqli("localhost", "root", "root", "clothing_catalog");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Must be logged in and cart must not be empty
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
  header('Location: cart.php');
  exit();
}

$user_id = $_SESSION['user_id'];
$order_batch_id = uniqid('order_', true);

// Insert's into orders database and Updates the products quantity in the database.
foreach ($_SESSION['cart'] as $product_id => $item) {
  $quantity = $item['quantity'];

  $insert_order = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, order_batch_id) VALUES (?, ?, ?, ?)");
  $insert_order->bind_param("iiis", $user_id, $product_id, $quantity, $order_batch_id);
  $insert_order->execute();
  $insert_order->close();

  $update_stock = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
  $update_stock->bind_param("ii", $quantity, $product_id);
  $update_stock->execute();
  $update_stock->close();
}

// Clear cart
unset($_SESSION['cart']);

header('Location: order-success.php');
exit();
?>
