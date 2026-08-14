<?php
session_start();
$error = "";

$redirectTarget = isset($_GET['redirect']) ? $_GET['redirect'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("localhost", "root", "root", "clothing_catalog");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $password = trim($_POST["password"]);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Incorrect email or password.";
  } else {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
      if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $redirect = isset($_POST['redirect']) && $_POST['redirect'] !== '' ? $_POST['redirect'] : 'index.php';
        header("Location: " . $redirect);
        exit();
      } else {
        $error = "Incorrect email or password.";
      }
    } else {
      $error = "Incorrect email or password.";
    }

    $stmt->close();
  }

  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Log In</title>
  <link rel="stylesheet" href="styles/login.css" />
</head>
<body>
  <div class="container">
    <div class="left-panel rounded-right">
      <form action="login.php?redirect=<?php echo urlencode($redirectTarget); ?>" method="POST" class="auth-form">
        <h2>Log In</h2>

        <?php if ($error): ?>
          <p class="error-message" id="errorMessage"><?php echo $error; ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" autocomplete="off" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirectTarget); ?>">
        <button type="submit">Login</button>
        <p>
          Don’t have an account?
          <a href="signup.php?redirect=<?php echo urlencode($redirectTarget); ?>">Sign Up</a>
        </p>
      </form>
    </div>

    <div class="right-panel">
      <h2>Welcome Back!<br>Let's Continue Your<br>Fashion Journey</h2>
      <h1>TMA</h1>
    </div>
  </div>

  <script>
    setTimeout(() => {
      const errorElement = document.getElementById('errorMessage');
      if (errorElement) errorElement.remove();
    }, 5000);
  </script>
</body>
</html>

