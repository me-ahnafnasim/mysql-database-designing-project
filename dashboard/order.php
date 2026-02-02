<?php
include "../connection.php"; // Adjust path if needed

// Fetch all orders with all associated customers via M:N junction table
$query = "
    SELECT 
        o.order_id,
        o.order_date,
        o.status,
        c.customer_id,
        CONCAT(c.first_name, ' ', c.last_name) AS full_name,
        c.email
    FROM orders o
    JOIN customer_order co ON o.order_id = co.order_id
    JOIN customer c ON co.customer_id = c.customer_id
    ORDER BY o.order_id, c.customer_id
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer ↔ Order (M:N)</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f0f5ff; }
        tr:hover { background: #fafafa; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align:center">Orders with Customers (Many-to-Many)</h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>#<?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['order_date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:#666;">
            No data found. Ensure the <code>customer_order</code> table exists and has records.
        </p>
    <?php endif; ?>
</div>

</body>
</html>


