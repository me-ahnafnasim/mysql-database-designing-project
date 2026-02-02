<?php
include "connection.php";

if (!isset($_GET["order_id"])) {
    die("Invalid order request");
}

$order_id = (int)$_GET["order_id"];

/* ---------------------------
   FETCH ORDER + CUSTOMER
----------------------------*/
$stmt = $conn->prepare("
    SELECT 
        o.order_id,
        o.order_date,
        o.status,
        c.email,
        c.phone
    FROM orders o
    JOIN customer c ON o.customer_id = c.customer_id
    WHERE o.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found");
}

/* ---------------------------
   FETCH ORDER ITEMS (M:N)
----------------------------*/
$stmt = $conn->prepare("
    SELECT 
        p.name,
        oi.quantity,
        oi.unit_price_at_time
    FROM order_item oi
    JOIN product p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Summary</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f2f2f2;
}
.container {
    max-width: 650px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
}
h2, h3 {
    text-align: center;
}
.row {
    display: flex;
    justify-content: space-between;
    margin: 8px 0;
}
.total {
    font-weight: bold;
    font-size: 1.1rem;
    margin-top: 12px;
}
hr {
    margin: 15px 0;
}
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #28a745;
    text-decoration: none;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="container">
    <h2>Order Summary</h2>

    <p><strong>Order ID:</strong> #<?= $order["order_id"] ?></p>
    <p><strong>Order Date:</strong> <?= $order["order_date"] ?></p>
    <p><strong>Status:</strong> <?= $order["status"] ?></p>

    <hr>

    <h3>Customer Information</h3>
    <p>Email: <?= htmlspecialchars($order["email"]) ?></p>
    <p>Phone: <?= htmlspecialchars($order["phone"]) ?></p>
    

    <hr>

    <h3>Ordered Products</h3>

    <?php while ($row = $items->fetch_assoc()): 
        $subtotal = $row["quantity"] * $row["unit_price_at_time"];
        $total += $subtotal;
    ?>
        <div class="row">
            <span><?= htmlspecialchars($row["name"]) ?> (x<?= $row["quantity"] ?>)</span>
            <span>€ <?= number_format($subtotal, 2) ?></span>
        </div>
    <?php endwhile; ?>

    <div class="total">
        Total Amount: € <?= number_format($total, 2) ?>
    </div>

    <a href="product.php">Continue Shopping</a>
</div>

</body>
</html>
