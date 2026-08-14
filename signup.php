<?php
session_start();
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("localhost", "root", "root", "clothing_catalog");

  if ($conn->connect_error) {
    $error = "Database connection failed.";
  } else {
    function clean_input($data) {
      return htmlspecialchars(strip_tags(trim($data)));
    }

    $first_name = clean_input($_POST["first_name"]);
    $last_name = clean_input($_POST["last_name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST["phone"]) && trim($_POST["phone"]) !== '' ? clean_input($_POST["phone"]) : null;
    $password_raw = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = "Invalid email format.";
    } elseif (strlen($password_raw) < 6) {
      $error = "Password must be at least 6 characters.";
    } else {
      $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);
      $created_at = date("Y-m-d H:i:s");

      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone, created_at)
        VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $first_name, $last_name, $email, $password_hashed, $phone, $created_at);

      if ($stmt->execute()) {
        // Automatically log in the user
        $_SESSION["user_id"] = $conn->insert_id;

        // Redirect after signup
        $redirect = isset($_POST['redirect']) && $_POST['redirect'] !== '' ? $_POST['redirect'] : 'index.php';
        header("Location: " . $redirect);
        exit();
      } else {
        $error = "Signup failed. Please try again.";
      }

      $stmt->close();
    }

    $conn->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link rel="stylesheet" href="styles/signup.css" />
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <h2>Your Style Begins Here.<br>Sign Up Now</h2>
      <h1>TMA</h1>
    </div>

    <div class="right-panel rounded-left">
      <form action="signup.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>" method="POST" class="auth-form">
        <h2>Create Account</h2>

        <?php if ($error): ?>
          <div class="error-message"><?php echo $error; ?></div>
        <?php elseif ($success): ?>
          <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="input-row">
          <input type="text" name="first_name" placeholder="First Name" autocomplete="off" required />
          <input type="text" name="last_name" placeholder="Last Name" autocomplete="off" required />
        </div>

        <div class="input-row">
          <input type="password" name="password" placeholder="Password" required />
          <input type="text" name="phone" placeholder="Phone (optional)" autocomplete="off" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

        </div>

        <input type="email" name="email" placeholder="Email" autocomplete="off" required />

        <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">

        <button type="submit">Create Account</button>
        <p>
          Already have an account? 
          <a href="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
            Login Here!
          </a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
