-- phpMyAdmin SQL Dump
-- Database: `clothing_catalog`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'Demo', 'User', 'demo@example.com', '$2y$10$Kxuf7js450pcZpFuacRKnudkmVA8dyZJT1IXi5iyxF32cw3tDZeoG', '1234567890', '2025-04-13 02:19:40'),
(6, 'Jane', 'Smith', 'jane@example.com', '$2y$10$UvB6l6DPY7XyUvvzQJ41AOlYktWTU1DWvnJpIT/97hz7O7NPLfE6u', '9876543210', '2025-04-26 06:59:22'),
(16, 'John', 'Doe', 'JohnDoe@gmail.com', '$2y$10$pB8tylODBXXCL3u7gA.kSelx3ZuQQKe5R1QZULkqPw57RgPCDKJrO', NULL, '2025-05-04 06:40:06');

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `name`, `category`, `gender`, `price`, `stock_quantity`, `description`, `image_path`) VALUES
(1, 'AE AirFlex+ Slim Straight Jean', 'bottom', 'men', '39.95', 50, 'AirFlex+: Authentic denim look with lightweight flexibility and comfort you have to feel to believe.', 'images/products/AE AirFlex+ Slim Straight Jean.png'),
(2, 'Button-Front Denim Tube Dress', 'dress', 'women', '39.99', 20, 'This non-stretch denim midi dress features a straight neckline and back, partial button front, belt loops, smocked back, slanted pockets, mock zip fly, frayed trim, back vent, and a straight silhouette.', 'images/products/Button-Front Denim Tube Dress.png'),
(3, 'J.VER Mens Cotton Linen Short Sleeve Button Down', 'top', 'men', '22.99', 25, 'This casual short sleeve shirt is made from soft, breathable cotton-linen fabric with anti-shrink treatment. It features a classic spread collar, button placket, a chest pocket for convenience, and an extra button for durability—perfect for warm-weather occasions and everyday wear.', 'images/products/J.VER Mens Cotton Linen Short Sleeve Button Down.png'),
(4, 'Jordan MVP', 'shoe', 'men', '124.99', 10, 'Whether you are an avid hooper or a die-hard fan of Jordan, the Jordan MVP lets you proclaim your fanaticism for the world of hoops like no other. Honouring Jordans first three championships, these silhouettes collect details from each respective years iconic matches to nod to the legend', 'images/products/Jordan MVP.png'),
(5, 'Seamless Scoop-Neck Mini Dress', 'dress', 'women', '19.99', 40, 'A seamless knit mini dress featuring a scoop neck, long sleeves, and bodycon silhouette.', 'images/products/Seamless Scoop-Neck Mini Dress.png'),
(6, 'Hanes EcoSmart Mens Fleece Sweatshirt', 'top', 'men', '22.99', 10, 'TWO IS BETTER THAN ONE\r\nHanes EcoSmart® mens fleece sweatshirt will surely become your new go-to wardrobe staple. Soft and plush, this cozy pullover sweatshirt is made from a midweight blended fabric featuring cotton sourced from American farms. Double-needle stitching at the neck and armholes further enhances the quality and strength of a classic mens crewneck pullover', 'images/products/Hanes Mens EcoSmart.png'),
(7, 'Mercedes - AMG Petronas Formula One Team Driver Cap', 'hat', 'unisex', '34.99', 10, 'Whether you\'re watching trackside or not, this Mercedes-AMG Petronas Formula One Team driver cap from adidas Motorsports lets you show your support for your favorite team. An adjustable strap means one size fits most heads comfortably. The pre-curved brim keeps your eyes on the road or the race, and the logo on the front leaves no doubt about who you\'re cheering for.\r\n\r\nThis product is made with at least 50% recycled materials. By reusing materials that have already been created, we help to reduce waste and our reliance on finite resources and reduce the footprint of the products we make.', 'images/products/Mercedes - AMG Petronas Formula One Team Driver Cap.png'),
(8, 'Ultraboost 1.0 Shoes', 'shoe', 'men', '179.99', 15, 'From a walk in the park to a weekend run with friends, these adidas Ultraboost 1.0 shoes are designed to keep you comfortable. An adidas PRIMEKNIT upper gently hugs your feet while BOOST on the midsole cushions from the first step to the last mile. The Stretchweb outsole flexes naturally for an energized ride, and Continental™ Rubber gives you the traction you need to keep that pep in your step.', 'images/products/Ultraboost 1.0 Shoes.png'),
(9, 'Miss Selfridge crochet long sleeve peplum knit top', 'top', 'women', '49.49', 50, '• Square cut neck\n• Panelled design\n• Open-weave knit\n• Long sleeves\n• Scalloped hem\n• Regular fit', 'images/products/MissSelfridge-crochet-long-sleeve.png'),
(10, 'Nike Free Metcon 6', 'shoe', 'women', '90.97', 50, 'The Free Metcon 6 opens your world of workout possibilities. We added even more forefoot flexibility to our most adaptable trainer and reinforced the heel with extra foam. That means more freedom for dynamic movements during plyos and cardio classes, plus the stable base you need for weights.', 'images/products/W+NIKE+FREE+METCON+6.png'),
(11, 'Abercrombie & Fitch Curve Love Mid Rise 90s Straight Jean', 'bottom', 'women', '47.50', 50, 'Our Curve Love 90\'s-style jeans in a light wash with a distressed hem. This fit features a 9.5” mid rise, is fitted at the waist and hips, and eases at the thigh into a straight, full-length leg shape. The viral fit that eliminates waist gap: Curve Love features additional room through the hip and thigh for curve-hugging comfort. This jean is made from our vintage stretch fabric which features both an authentic vintage look and contains slight built-in stretch for additional comfort. Imported.', 'images/products/Curve_Love_Mid_Rise_90s_Straight_Jean.png'),
(12, 'Nike Apex Bucket Hat', 'hat', 'unisex', '29.99', 49, 'Welcome the Nike Apex Bucket into your lineup. The mid-depth design is made with soft cotton and features an embroidered Futura logo for a clean Nike finish. The wash treatment softens the feel and gives it a vintage look that keeps aging to perfection the more you wear it.', 'images/products/U+NK+APEX+BUCKET+SQ+FUT+WSH+L.png'),
(13, 'FUTURE.PUMA.ARCHIVE - Women\'s Graphic Baby Tee', 'top', 'women', '29.99', 50, 'Turn heads with this PUMA baby tee featuring a graphic suede puff print and rib inserts with tipping at the shoulders. The ribbed neckline', 'images/products/FUTURE.PUMA_Womens_Graphic_Baby_Tee.png'),
(14, 'Nike ACG - Men\'s UV Hiking Pants', 'bottom', 'men', '114.99', 25, 'From tackling tough, mountainous terrain to taking a morning stroll through town, these versatile hiking pants from ACG are made for all your daily adventures. The relaxed, straight-leg fit is designed to hit at the ankle for casual, daily wear. Their lightweight, stretchy build and UV-blocking fabric make them an ideal building block for your outfit.', 'images/products/M+ACG+UV+HIKE+PANT.png'),
(15, 'BMW M Motorsport - Puma Men\'s Graphic Tee', 'top', 'men', '39.99', 50, 'Show your love for BMW M Motorsport in this graphic tee. It has a dynamic graphic on the front that pays homage to a legendary race', 'images/products/BMW-M-Motorsport-Car-Graphic-Tee-Men.png'),
(17, 'H&M Fine-Knit T-Shirt', 'top', 'women', '24.99', 40, 'T-shirt in a dense, fine knit. Ribbed trim at neckline and gently dropped shoulders.<br><br><strong>Length:</strong> Short<br><strong>Fit:</strong> Regular fit<br><strong>Neckline:</strong> Round Neck<br><strong>Description:</strong> Dusty green, Solid-color<br><strong>Imported:</strong> Yes', 'images/products/H&M_Fine-Knit_T-Shirt.png'),
(18, 'Ray-Ban - AVIATOR CLASSIC', 'accessories', 'men', '119.99', 5, 'Ray Ban Luxury Aviator Sunglasses<br><br><strong>FRAME DESCRIPTION</strong><br><strong>Frame Shape:</strong> Pilot<br><strong>Frame Color:</strong> Polished Gold<br><strong>Frame Material:</strong> Metal<br><strong>Temple Color:</strong> Gold<br><br><strong>PRODUCT DIMENSIONS</strong><br><strong>Size:</strong> 58 14 mm<br><strong>Lens Height:</strong> 50.1 mm<br><strong>Temple Length:</strong> 135 mm<br><br><strong>LENS INFORMATION</strong><br><strong>Lens Color:</strong> Black<br><strong>Treatment:</strong> Solid Color<br><br><strong>FACE COVERAGE</strong><br><strong>Face Coverage:</strong> Standard<br><strong>Bridge & Nosepads:</strong> Adjustable Nose Pads', 'images/products/Ray_Ban_Aviator_Classic_Sunglasses.png'),
(19, 'UA Vanish Elite', 'bottom', 'men', '49.50', 15, 'The Under Armour Vanish Elite Shorts were built specifically for total mobility, with ultra-stretchy materials and a hem designed for how your legs move. That means you have full range of motion, no matter how dynamic your workout is.', 'images/products/Under_Armour_Vanish_Elite.png'),
(20, 'Rigid Pendant Necklace', 'accessories', 'women', '29.99', 25, 'Short, rigid necklace in metal with an asymmetric, hammered-finish pendant centered with a plastic stone. Adjustable length with trigger clasp.', 'images/products/H&M_Rigid_Pendant_Necklace.png');

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_batch_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `order_date`, `order_batch_id`) VALUES
(15, 1, 6, 1, '2025-04-27 07:28:22', 'order_680ddc96508bf6.99108965'),
(16, 1, 1, 1, '2025-04-27 07:28:22', 'order_680ddc96508bf6.99108965'),
(17, 16, 12, 1, '2025-05-04 06:44:18', 'order_68170cc22a67f3.70247814'),
(18, 16, 1, 1, '2025-05-04 06:44:18', 'order_68170cc22a67f3.70247814'),
(19, 16, 15, 1, '2025-05-04 06:49:13', 'order_68170de952ed60.97760602'),
(20, 16, 17, 1, '2025-05-04 09:07:49', 'order_68172e658e96b7.51096130');

-- --------------------------------------------------------
-- Table structure for table `reviews`
-- --------------------------------------------------------

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_text` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `review_text`, `created_at`) VALUES
(1, 6, 1, 'super cozy!', '2025-04-27 07:29:14'),
(3, 1, 1, '👍', '2025-05-04 04:44:57'),
(6, 15, 16, 'Awesome shirt 🔥', '2025-05-04 08:15:15');

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

-- --------------------------------------------------------
-- Constraints
-- --------------------------------------------------------

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;