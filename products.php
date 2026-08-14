<?php
include 'db.php';

function normalize_search($term) {
  $term = strtolower(trim($term));
  $term = preg_replace("/[^\w\s]/", '', $term);
  if (substr($term, -1) === 's' && strlen($term) > 3) {
    $term = rtrim($term, 's');
  }
  return $term;
}

$search = isset($_GET['search']) ? normalize_search($_GET['search']) : '';
$searchParam = '%' . $search . '%';

if ($search !== '') {
  $stmt = $conn->prepare("
    SELECT id, name, category, gender, price, stock_quantity, description, image_path 
    FROM products 
    WHERE 
      LOWER(name) LIKE ? OR 
      LOWER(category) LIKE ? OR 
      LOWER(description) LIKE ?
  ");
  $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
} else {
  $stmt = $conn->prepare("
    SELECT id, name, category, gender, price, stock_quantity, description, image_path 
    FROM products
  ");
}

$stmt->execute();
$stmt->bind_result($id, $name, $category, $gender, $price, $stock_quantity, $description, $image_path);

$hasResults = false;

if ($search !== '') {
  echo "<p style='margin: 20px 0; font-size: 18px;'>Showing results for <strong>" . htmlspecialchars($_GET['search']) . "</strong></p>";
}

while ($stmt->fetch()):
  $hasResults = true;
?>
  <div class="product-card">
    <a href="product-page.php?id=<?php echo urlencode($id); ?>">
      <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($name); ?>">
    </a>

    <div class="product-details">
      <p class="product-price">$<?php echo htmlspecialchars(number_format($price, 2)); ?></p>

      <form action="add-to-cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
      </form>
    </div>
  </div>
<?php endwhile; ?>

<?php
if (!$hasResults) {
  echo "<p>No products found for '<strong>" . htmlspecialchars($_GET['search']) . "</strong>'</p>";
}

$stmt->close();
$conn->close();
?>
