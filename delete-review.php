<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "clothing_catalog");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// checks for post request and review id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review_id'])) {
  $review_id = intval($_POST['review_id']);
  $user_id = $_SESSION['user_id'];

  // Check's if the review belongs to the currently logged in user
  $check_stmt = $conn->prepare("SELECT * FROM reviews WHERE id = ? AND user_id = ?");
  $check_stmt->bind_param("ii", $review_id, $user_id);
  $check_stmt->execute();
  $result = $check_stmt->get_result();

  if ($result->fetch_assoc()) {
    $delete_stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $delete_stmt->bind_param("i", $review_id);
    $delete_stmt->execute();
  }
}

// Redirect's back to the previous page (the prodcuts page)
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
