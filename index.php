<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Clothing Store</title>
  <link rel="stylesheet" href="styles/navbar.css">
  <link rel="stylesheet" href="styles/home.css">
  <link rel="stylesheet" href="styles/products.css">
</head>
<body>

  <?php include 'navbar.php'; ?>

  <section class="featured-section">
    <h2>FEATURED</h2>
    <div class="product-grid">
      <?php include 'products.php'; ?>
    </div>
  </section>

</body>
</html>