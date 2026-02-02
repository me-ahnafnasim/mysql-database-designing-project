<?php
include "connection.php";
session_start();

if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
    header("Location: product.php");
    exit;
}

$error = "";
$success = "";

// Handle checkout form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);

    if (empty($email) || empty($address) || empty($phone)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        // Step 1: Insert into customer (even for guest!)
        $stmt = $conn->prepare("INSERT INTO customer (first_name, last_name, email, phone, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone);
        // Since we don't have names, use "Guest"
        $first_name = "Guest";
        $last_name = "";

        if ($stmt->execute()) {
            $customer_id = $conn->insert_id;

            // Step 2: Create order
            $order_date = date("Y-m-d H:i:s");
            $status = "Pending";
            $stmt = $conn->prepare("INSERT INTO orders (customer_id, order_date, status) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $customer_id, $order_date, $status);
            $stmt->execute();
            $order_id = $conn->insert_id;

            // Step 3: Add order items
            foreach ($_SESSION["cart"] as $product_id => $quantity) {
                $stmt = $conn->prepare("SELECT unit_price FROM product WHERE product_id = ?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();
                $unit_price = $product["unit_price"];

                $stmt = $conn->prepare("INSERT INTO order_item (order_id, product_id, quantity, unit_price_at_time) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $unit_price);
                $stmt->execute();
            }

            // Clear cart
            $_SESSION["cart"] = [];
            header("Location: order_summary.php?order_id=" . $order_id);
exit;


            #$success = "Order placed successfully! Order ID: #{$order_id}";
        } else {
            $error = "Failed to place order. Please try again.";
        }
    }
}

// Load cart items for display
$product_ids = array_keys($_SESSION["cart"]);
$placeholders = str_repeat('?,', count($product_ids) - 1) . '?';
$stmt = $conn->prepare("SELECT product_id, name, unit_price FROM product WHERE product_id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $pid = $row["product_id"];
    $qty = $_SESSION["cart"][$pid];
    $subtotal = $row["unit_price"] * $qty;
    $cart_items[] = [
        'name' => $row["name"],
        'unit_price' => $row["unit_price"],
        'quantity' => $qty,
        'subtotal' => $subtotal
    ];
    $total += $subtotal;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout - Guest</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #1a2530, #2c3e50);
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .checkout-container {
      background: #fff;
      color: #222;
      padding: 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    h2 { text-align: center; margin-bottom: 20px; }
    .error { color: #dc3545; text-align: center; margin: 10px 0; }
    .success { color: #28a745; text-align: center; margin: 10px 0; }
    input[type="email"], input[type="text"], textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 700;
      cursor: pointer;
    }
    button:hover { background: #218838; }
    .cart-summary {
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }
    .cart-item {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
    }
  </style>
</head>
<body>
  <div class="checkout-container">
    <h2>Guest Checkout</h2>

    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success"><?= htmlspecialchars($success) ?></div>
      <p style="text-align:center; margin-top:20px;">
        <a href="product.php" style="color:#28a745; text-decoration:underline;">Continue Shopping</a>
      </p>
    <?php else: ?>
      <!-- Cart Summary -->
      <div class="cart-summary">
        <h3>Your Order</h3>
        <?php foreach ($cart_items as $item): ?>
          <div class="cart-item">
            <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</span>
            <span>€ <?= number_format($item['subtotal'], 2) ?></span>
          </div>
        <?php endforeach; ?>
        <div class="cart-item" style="font-weight:bold; margin-top:10px;">
          <span>Total:</span>
          <span>€ <?= number_format($total, 2) ?></span>
        </div>
      </div>

      <!-- User Info Form -->
      <form method="post">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <textarea name="address" placeholder="Shipping Address" rows="3" required></textarea>
        <button type="submit">Place Order</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>