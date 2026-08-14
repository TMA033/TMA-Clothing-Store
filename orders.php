<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

$conn = new mysqli("localhost", "root", "root", "clothing_catalog");

if ($conn->connect_error) {
  die("Connection failed");
}

$user_id = $_SESSION['user_id'];

// Get all orders for the user (newest first)
$stmt = $conn->prepare(
  "SELECT orders.order_batch_id, orders.quantity, orders.order_date, 
          products.id AS product_id, products.name, products.price, products.image_path
   FROM orders
   JOIN products ON orders.product_id = products.id
   WHERE orders.user_id = ?
   ORDER BY orders.order_date DESC, orders.id ASC"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
$order_dates = [];

while ($row = $result->fetch_assoc()) {
  $batch_id = $row['order_batch_id'];
  if (!isset($orders[$batch_id])) {
    $orders[$batch_id] = [];
    $order_dates[$batch_id] = $row['order_date'];
  }
  $orders[$batch_id][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders - TMA</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/orders.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<h1 class="orders-title">My Orders</h1>

<div class="orders-container">
<?php if (!empty($orders)): ?>
  <?php foreach ($orders as $batch_id => $batch_orders): ?>
    <div class="order-group">
      <h2>Order ID: <?php echo htmlspecialchars($batch_id); ?></h2>
      <p class="order-date" style="text-align: center; font-weight: bold;">Order Date: <?php echo date("M j, Y", strtotime($order_dates[$batch_id])); ?></p>

      <?php
        $totalBatchPrice = 0;
        foreach ($batch_orders as $order): 
          $itemTotal = $order['price'] * $order['quantity'];
          $totalBatchPrice += $itemTotal;
      ?>
        <div class="order-item">
          <a href="product-page.php?id=<?php echo $order['product_id']; ?>">
            <img src="<?php echo htmlspecialchars($order['image_path']); ?>" alt="Product Image" class="order-image">
          </a>
          <div class="order-info">
            <h3>
              <a href="product-page.php?id=<?php echo $order['product_id']; ?>" style="text-decoration: none; color: inherit;">
                <?php echo htmlspecialchars($order['name']); ?>
              </a>
            </h3>
            <p>Quantity: <?php echo $order['quantity']; ?></p>
            <p>Item Total: $<?php echo number_format($itemTotal, 2); ?></p>
          </div>
        </div>
      <?php endforeach; ?>

      <?php $grandTotal = $totalBatchPrice * 1.06; ?>
      <div class="order-total">
        Total for this order: $<?php echo number_format($grandTotal, 2); ?>
        <p style="color: #555; font-size: 15px; font-weight: normal;">(including tax & shipping)</p>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p class="no-orders">You haven't placed any orders yet.</p>
<?php endif; ?>
</div>

</body>
</html>
