# TMA Clothing Store

TMA is a fully functional online clothing store built with PHP, MySQL, HTML, CSS, and JavaScript. It allows users to browse products, manage their shopping cart, register/login, and place orders.

---

## Project Description

This project simulates a clothing e-commerce site where users can sign up, log in, view products, add them to a cart, and complete the checkout process. Users can also leave reviews on products they’ve purchased and view a history of their past orders.

---

##  Features Implemented

- User registration and login with session management
- Product catalog fetched from a MySQL database
- Individual product pages with images, pricing, descriptions, and user reviews
- Shopping cart functionality (add, update quantity, remove)
- Checkout including subtotal, tax calculation (6%), and final order total
- Order placement with stock reduction
- Order history page displaying previous purchases and order dates
- Review system:
  - Only verified purchasers can leave reviews
  - One review per user per product
  - Review deletion via confirmation modal
- Scroll position preserved after review actions (submission or deletion)
- Redirects that return users to previous page after login/signup
- Responsive design using custom CSS
- Input sanitization and basic validation
- Product links on order history pages lead back to product detail pages

---

## Local Installation & Setup

1. **Clone the repository:**
  - `git clone https://github.com/TMA033/TMA-Clothing-Store.git`

2. **Set up local server:**
  - Move the project folder to your local server root (e.g., `htdocs` in MAMP/XAMPP).

3. **Import Database:**
  - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
  - Create a database named `clothing_catalog`.
  - Click **Import** and select `clothing_catalog.sql` from the project root.

4. **Configure Database Connection:**
  - Open `db.php` and verify your MySQL credentials match your local setup:
    - `$servername = "localhost";`
    - `$username   = "root";`
    - `$password   = "root";`
    - `$dbname     = "clothing_catalog";`

5. **Run the project:**
  - Open your browser and navigate to `http://localhost/TMA-Clothing-Store/index.php`.

---

## Credits

- Developed by Toyosi Adeniji
- Fonts and icons via Google Fonts / Font Awesome
- Product images sourced from public websites and used for demonstration purposes only