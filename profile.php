<?php
session_start();

// User must be logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

$conn = new mysqli("localhost", "root", "root", "clothing_catalog");

if ($conn->connect_error) {
  die("Connection failed");
}

$user_id = $_SESSION['user_id'];

// Get user information
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - TMA</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/profile.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="profile-container">
  <h1>My Account</h1>

  <!-- Success Message -->
  <?php if (isset($_SESSION['success_message'])): ?>
    <p class="success-message" id="successMessage"><?php echo $_SESSION['success_message']; ?></p>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <!-- Error Message -->
  <?php if (isset($_SESSION['error_message'])): ?>
    <p class="error-message" id="errorMessage"><?php echo $_SESSION['error_message']; ?></p>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <form action="update-profile.php" method="POST" class="profile-form">

    <label>First Name:</label>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Phone (optional)">

    <hr>
    <h3 style="text-align: center; margin: 30px 0 10px;">Change Password</h3>

    <label>Current Password:</label>
    <input type="password" name="current_password" placeholder="Enter current password">

    <label>New Password:</label>
    <input type="password" name="new_password" placeholder="Enter new password">

    <label>Confirm New Password:</label>
    <input type="password" name="confirm_password" placeholder="Confirm new password">

    <button type="submit" class="save-btn">Save Changes</button>

  </form>
</div>


<script>
  setTimeout(() => {
    const successElement = document.getElementById('successMessage');
    const errorElement = document.getElementById('errorMessage');

    if (successElement) {
      successElement.remove();
    }
    if (errorElement) {
      errorElement.remove();
    }
  }, 5000);
</script>

</body>
</html>
