<?php session_start(); ?>

<header class="navbar">

  <a href="index.php" class="logo">TMA</a>

  <!-- Navbar's Search form -->
  <form action="index.php" method="GET" class="search-container">
    <input 
      type="text" 
      name="search" 
      class="search-bar" 
      placeholder="Search"
      autocomplete="off"
      value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
    >
    <button class="search-btn">
      <img class="search-icon" src="images/Icons/icons8-search.svg" alt="Search">
    </button>
  </form>

  <div class="nav-icons">
    <!-- different right side nav icons depending on logged in or not -->
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="orders.php" class="nav-item bold">ORDERS</a>

      <a href="cart.php" class="nav-item">
        <img class="cart-icon" src="images/Icons/cart-shopping-solid.svg" alt="Cart">
      </a>

      <a href="profile.php" class="nav-item">
        <img class="profile-icon" src="images/Icons/user-solid.svg" alt="Profile">
      </a>

      <a href="logout.php" class="nav-item bold">LOGOUT</a>
    <?php else: ?>
      <a href="cart.php" class="nav-item">
        <img class="cart-icon" src="images/Icons/cart-shopping-solid.svg" alt="Cart">
      </a>

      <a href="login.php" class="nav-item bold">LOGIN</a>
    <?php endif; ?>
  </div>
</header>
