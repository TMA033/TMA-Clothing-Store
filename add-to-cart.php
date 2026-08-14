<?php
session_start();

// Create cart if not exists
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Get product ID and quantity
if (isset($_POST['product_id'], $_POST['quantity'])) {
  $product_id = intval($_POST['product_id']);
  $quantity = intval($_POST['quantity']);

  // Connect to DB
  $conn = new mysqli("localhost", "root", "root", "clothing_catalog");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT name, price, image_path FROM products WHERE id = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();

  if ($product) {
    // If product already in cart, update quantity
    if (isset($_SESSION['cart'][$product_id])) {
      $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
      // Assign a delivery date once when added (its just random)
      $delivery_date = date('l, M j', strtotime('+' . rand(1, 3) . ' days'));

      $_SESSION['cart'][$product_id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image_path'],
        'quantity' => $quantity,
        'delivery_date' => $delivery_date
      ];
    }
  }

  $stmt->close();
  $conn->close();
}

// Redirect to cart
header("Location: cart.php");
exit();
?>
