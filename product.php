<?php
// ✅ MUST be at the VERY TOP – no space, no HTML before!
include "connection.php";
session_start();

// Initialize cart if not exists
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = []; // product_id => quantity
}

// Handle Add to Cart
if (isset($_POST["add_to_cart"])) {
    $pid = (int)$_POST["product_id"];
    $qty = (int)$_POST["quantity"];

    if ($pid > 0 && $qty > 0) {
        if (!isset($_SESSION["cart"][$pid])) {
            $_SESSION["cart"][$pid] = 0;
        }
        $_SESSION["cart"][$pid] += $qty;
    }

    // ✅ Redirect AFTER processing – prevents resubmit
    header("Location: product.php");
    exit; // ⚠️ Always exit after header()
}

// Count cart items
$cart_count = 0;
foreach ($_SESSION["cart"] as $q) {
    $cart_count += (int)$q;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Products</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #1a2530, #2c3e50);
      color: #ffffff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .container {
      width: 100%;
      max-width: 1400px;
      text-align: center;
      padding: 20px;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      margin-bottom: 20px;
    }

    h2 {
      margin: 0;
      font-size: 2.2rem;
      font-weight: 600;
    }

    .cart-link {
      background: #ffc107;
      color: #222;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 700;
      text-decoration: none;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
      margin-bottom: 30px;
    }

    .product-card {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .card-image {
      width: 100%;
      height: 160px;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .card-body {
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      text-align: left;
      background-color: #ffcccc;
    }

    .card-title { font-size: 1.15rem; font-weight: 700; color: #222; }
    .card-price { font-size: 1.1rem; font-weight: 800; color: #28a745; }
    .card-description { font-size: 0.95rem; color: #555; }
    .card-id { font-size: 0.85rem; color: #888; }

    .add-row {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-top: 8px;
    }

    .qty {
      width: 70px;
      padding: 8px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    .btn-add {
      padding: 10px 14px;
      border: none;
      border-radius: 8px;
      font-weight: 700;
      cursor: pointer;
      background: #28a745;
      color: #fff;
    }

    .btn-add:hover { background: #218838; }

    .no-products {
      grid-column: 1 / -1;
      padding: 20px;
      color: #ff6b6b;
      font-weight: 600;
      text-align: center;
      border: 1px dashed #ffcccc;
      border-radius: 12px;
      background: rgba(255,255,255,0.08);
    }

    .back-btn {
      display: inline-block;
      text-decoration: none;
      background: #28a745;
      color: white;
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="topbar">
      <h2>All Products</h2>
      <a class="cart-link" href="cart.php">Cart (<?= $cart_count ?>)</a>
    </div>

    <div class="product-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM product");

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $img = !empty($row['image']) ? $row['image'] : "https://via.placeholder.com/300x200?text=No+Image";
          $pid = (int)$row["product_id"];

          echo "
            <div class='product-card'>
              <div class='card-image'>
                <img src='" . htmlspecialchars($img) . "' alt='Product Image'>
              </div>
              <div class='card-body'>
                <div class='card-title'>" . htmlspecialchars($row['name']) . "</div>
                <div class='card-price'>€ " . htmlspecialchars($row['unit_price']) . "</div>
                <div class='card-description'>" . htmlspecialchars($row['description']) . "</div>
                <div class='card-id'>Product ID: {$pid}</div>

                <form method='post' class='add-row'>
                  <input type='hidden' name='product_id' value='{$pid}'>
                  <input class='qty' type='number' name='quantity' min='1' value='1' required>
                  <button class='btn-add' type='submit' name='add_to_cart'>Add to Cart</button>
                </form>
              </div>
            </div>
          ";
        }
      } else {
        echo "<div class='no-products'>No Products Found</div>";
      }
      ?>
    </div>

    <a href='index.php' class='back-btn'>Back to Home</a>
  </div>

</body>
</html>