<?php
// Include your existing connection file
include "../connection.php"; // or "../Connection.php" — adjust as needed

// Fetch all orders with their products via the junction table
$sql = "
    SELECT 
        o.order_id,
        o.order_date,
        o.status,
        p.product_id,
        p.name AS product_name,
        p.unit_price AS current_unit_price,
        oi.quantity,
        oi.unit_price_at_time
    FROM orders o
    JOIN order_item oi ON o.order_id = oi.order_id
    JOIN product p ON oi.product_id = p.product_id
    ORDER BY o.order_id, p.name
";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>All Orders with Products (M:N)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f3f5;
        }
        .order-id {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Orders with Products (M:N Relationship)</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price at Order</th>
                    <th>Current Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="order-id">#<?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['order_date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= (int)$row['quantity'] ?></td>
                        <td>$<?= number_format($row['unit_price_at_time'], 2) ?></td>
                        <td>$<?= number_format($row['current_unit_price'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: #666;">No order data found. Make sure the <code>order_item</code> junction table exists and has data.</p>
    <?php endif; ?>

</div>

<?php
mysqli_close($conn);
?>

</body>
</html>
