<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "clothing_catalog");
$conn->set_charset("utf8mb4"); // (ALLOWS SUPPORT FOR EMOJIS + OTHER CHARACTERS)

if ($conn->connect_error) {
  die("Connection failed");
}

// Get product id from URL
if (!isset($_GET['id'])) {
  die("No product specified.");
}
$product_id = intval($_GET['id']);

// Fetch product info
$stmt = $conn->prepare("SELECT name, description, price, image_path FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
  die("Product not found.");
}

// Fetch existing reviews
$review_stmt = $conn->prepare(
  "SELECT reviews.id, users.first_name, users.last_name, reviews.review_text, reviews.created_at, reviews.user_id
   FROM reviews 
   JOIN users ON reviews.user_id = users.id 
   WHERE product_id = ? 
   ORDER BY reviews.created_at DESC");
$review_stmt->bind_param("i", $product_id);
$review_stmt->execute();
$reviews = $review_stmt->get_result();

// Check if user can review
$canReview = false;
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $order_stmt = $conn->prepare("SELECT id FROM orders WHERE user_id = ? AND product_id = ?");
  $order_stmt->bind_param("ii", $user_id, $product_id);
  $order_stmt->execute();
  $order_result = $order_stmt->get_result();

  if ($order_result->fetch_assoc()) {
    $canReview = true;
  }
}

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $canReview) {
  $review_text = htmlspecialchars(trim($_POST["review_text"]));

  if (!empty($review_text)) {
    // Check's if user already submitted a review for this product
    $check_stmt = $conn->prepare("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?");
    $check_stmt->bind_param("ii", $product_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    // if not, submit the review
    if ($check_result->num_rows === 0) {
      $insert_stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, review_text) VALUES (?, ?, ?)");
      $insert_stmt->bind_param("iis", $product_id, $user_id, $review_text);
      $insert_stmt->execute();
  
      header("Location: product-page.php?id=" . $product_id);
      exit();
    } else {
      $review_error = "You've already submitted a review for this product.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($product['name']); ?> - TMA</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/product-page.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="product-main-container">
  <div class="product-image-container">
    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
  </div>

  <div class="product-info-container">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>

    <form action="add-to-cart.php" method="POST">
      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

      <div class="quantity-selector">
        <button type="button" class="qty-btn" onclick="decreaseQuantity()">-</button>
        <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
        <button type="button" class="qty-btn" onclick="increaseQuantity()">+</button>
      </div>

      <button type="submit" class="add-to-cart-btn">Add To Cart</button>
    </form>
  </div>
</div>

<div class="product-details">
  <h2>Details:</h2>
  <p><?php echo $product['description']; ?></p>
</div>

<?php if ($canReview): ?>
  <div class="review-form">
    <h3>Write a Review</h3>
    
    <?php if (!empty($review_error)): ?>
      <p id="reviewError" style="color: red; font-weight: bold;"><?php echo $review_error; ?></p>
    <?php endif; ?>
    
    <form id="reviewForm" action="" method="POST">
      <textarea name="review_text" placeholder="Write a review!" required></textarea>
      <button type="submit">Submit Review</button>
    </form>
  </div>
<?php elseif (!isset($_SESSION['user_id'])): ?>
  <p class="login-message">
    <a href="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Log in</a> to write a review!
  </p>
<?php elseif (!$canReview): ?>
  <p class="login-message">You must purchase this product before leaving a review.</p>
<?php endif; ?>

<div class="reviews-section">
  <h2>Reviews</h2>

  <?php if ($reviews->num_rows > 0): ?>
    <?php while ($review = $reviews->fetch_assoc()): ?>
      <div class="review">
        <strong><?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></strong>
        <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
        <small><?php echo date("M j, Y", strtotime($review['created_at'])); ?></small>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
          <form action="delete-review.php" method="POST" class="delete-review-form" data-review-id="<?php echo $review['id']; ?>" style="margin-top: 10px;">
            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
            <button type="button" class="delete-btn open-delete-modal">Delete</button>
          </form>
        <?php endif; ?>

      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No reviews yet.</p>
  <?php endif; ?>
</div>

<!-- This is the Modal for delete confirmation -->
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <p>Are you sure you want to delete your review?</p>
    <div class="modal-buttons">
      <button id="confirmDelete" class="modal-btn confirm">Yes, Delete</button>
      <button id="cancelDelete" class="modal-btn cancel">Cancel</button>
    </div>
  </div>
</div>


<!-- Quantity buttons script -->
<script>
function decreaseQuantity() {
  const qtyInput = document.getElementById('quantity');
  let current = parseInt(qtyInput.value);
  if (current > 1) {
    qtyInput.value = current - 1;
  }
}

function increaseQuantity() {
  const qtyInput = document.getElementById('quantity');
  qtyInput.value = parseInt(qtyInput.value) + 1;
}
</script>


<!-- Delete modal script -->
<script>
let selectedForm = null;

const modal = document.getElementById('deleteModal');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete = document.getElementById('cancelDelete');

document.querySelectorAll('.open-delete-modal').forEach(button => {
  button.addEventListener('click', function() {
    selectedForm = this.closest('form');
    modal.style.display = 'flex';
  });
});

confirmDelete.addEventListener('click', () => {
  if (selectedForm) {
    localStorage.setItem('scrollPosition', window.scrollY);
    selectedForm.submit();
  }
});

cancelDelete.addEventListener('click', () => {
  modal.style.display = 'none';
  selectedForm = null;
});

// Close modal when clicking outside
window.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.style.display = 'none';
    selectedForm = null;
  }
});
</script>


<!-- Review Error -->
<script>
  setTimeout(() => {
    const reviewError = document.getElementById('reviewError');
    if (reviewError) {
      reviewError.remove();
    }
  }, 5000);
</script>


<!--Preserves the scroll position when submitting review (success/error)-->
<script>
  const reviewForm = document.getElementById('reviewForm');
  if (reviewForm) {
    reviewForm.addEventListener('submit', () => {
      localStorage.setItem('scrollPosition', window.scrollY);
    });
  }

  window.addEventListener('load', ()=> {
    const scrollY = localStorage.getItem('scrollPosition');
    if (scrollY !== null) {
      window.scrollTo(0, parseInt(scrollY));
      localStorage.removeItem('scrollPosition'); // Clean up
    }
  })
</script>

</body>
</html>
