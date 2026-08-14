<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $conn = new mysqli("localhost", "root", "root", "clothing_catalog");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $user_id = $_SESSION['user_id'];

  function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
  }

  $first_name = clean_input($_POST['first_name']);
  $last_name = clean_input($_POST['last_name']);
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $phone = isset($_POST['phone']) && trim($_POST['phone']) !== '' ? clean_input($_POST['phone']) : null;


  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_message'] = "Invalid email address.";
    header('Location: profile.php');
    exit();
  }

  // Update account info (name, email, phone)
  $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
  $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $user_id);
  $stmt->execute();
  $stmt->close();

  // Handle password change if provided
  $current_password = $_POST['current_password'] ?? '';
  $new_password = $_POST['new_password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';

  if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
      $_SESSION['error_message'] = "Please fill out all password fields.";
      header('Location: profile.php');
      exit();
    }

    if ($new_password !== $confirm_password) {
      $_SESSION['error_message'] = "New passwords do not match.";
      header('Location: profile.php');
      exit();
    }

    // Fetch current hashed password
    $pass_stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $pass_stmt->bind_param("i", $user_id);
    $pass_stmt->execute();
    $pass_stmt->bind_result($hashed_password);
    $pass_stmt->fetch();
    $pass_stmt->close();

    // Verify current password
    if (!password_verify($current_password, $hashed_password)) {
      $_SESSION['error_message'] = "Current password is incorrect.";
      header('Location: profile.php');
      exit();
    }

    // Hash and update new password
    $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $update_pass_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update_pass_stmt->bind_param("si", $new_hashed, $user_id);
    $update_pass_stmt->execute();
    $update_pass_stmt->close();

    $_SESSION['success_message'] = "Password changed successfully!";
  } else {
    $_SESSION['success_message'] = "Account information updated successfully!";
  }

  $conn->close();
  header('Location: profile.php');
  exit();
} else {
  header('Location: profile.php');
  exit();
}
