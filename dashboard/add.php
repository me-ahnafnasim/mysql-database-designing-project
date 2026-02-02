<?php
// Start session if needed (not required here, but safe)
session_start();

// Include database connection
include "../connection.php";

$message = '';

// ===========================
// HANDLE DELETE
// ===========================
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $message = "<div class='msg' style='color:green;'>Product deleted successfully!</div>";
    } else {
        $message = "<div class='msg' style='color:red;'>Error deleting product: " . mysqli_stmt_error($stmt) . "</div>";
    }
    mysqli_stmt_close($stmt);
    header("Location: add_product.php");
    exit;
}

// ===========================
// HANDLE EDIT FORM SUBMISSION
// ===========================
if (isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $category_id = $_POST['category_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $unit_price = floatval($_POST['unit_price']);
    $stock_qty = intval($_POST['stock_qty']);

    $stmt = mysqli_prepare($conn, "UPDATE product SET category_id = ?, name = ?, description = ?, unit_price = ?, stock_qty = ? WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "issdii", $category_id, $name, $description, $unit_price, $stock_qty, $update_id);

    if (mysqli_stmt_execute($stmt)) {
        $message = "<div class='msg' style='color:green;'>Product updated successfully!</div>";
        echo "<script>setTimeout(() => window.location.href = 'add_product.php', 1000);</script>";
        mysqli_stmt_close($stmt);
        exit;
    } else {
        $message = "<div class='msg' style='color:red;'>Update error: " . mysqli_stmt_error($stmt) . "</div>";
    }
    mysqli_stmt_close($stmt);
}

// ===========================
// HANDLE ADD NEW PRODUCT
// ===========================
if (isset($_POST['submit'])) { // ✅ Now works because button has name="submit"
    $category_id = $_POST['category_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $unit_price = floatval($_POST['unit_price']);
    $stock_qty = intval($_POST['stock_qty']);

    $sql = "INSERT INTO product (category_id, name, description, unit_price, stock_qty) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issdi", $category_id, $name, $description, $unit_price, $stock_qty);

    if (mysqli_stmt_execute($stmt)) {
        $message = "<div class='msg' style='color:green;'>Product added successfully!</div>";
        echo "<script>setTimeout(() => window.location.href = 'add_product.php', 1000);</script>";
    } else {
        $message = "<div class='msg' style='color:red;'>Insert error: " . mysqli_stmt_error($stmt) . "</div>";
    }
    mysqli_stmt_close($stmt);
}

// ===========================
// FETCH PRODUCT FOR EDIT 
// ===========================
$edit_mode = false;
$edit_data = null;
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if ($edit_data) {
        $edit_mode = true;
    } else {
        die("Product not found.");
    }
}

// ===========================
// FETCH ALL PRODUCTS FOR DISPLAY
// ===========================
$products_result = mysqli_query($conn, "SELECT * FROM product ORDER BY product_id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $edit_mode ? 'Edit Product' : 'Add Product'; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        /* ===== HEADER STYLES ===== */
        header {
            background: #343a40;
            padding: 12px 0;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        header a {
            padding: 10px 20px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: opacity 0.2s;
            text-align: center;
        }
        header a:hover {
            opacity: 0.9;
        }
        .btn-dashboard { background: #007bff; }
        .btn-add { background: #28a745; }
        .btn-categories { background: #fd7e14; color: #212529; }

        .container {
            width: 95%;
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input,
        .form-group textarea,
        .form-group button {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        button {
            background: #007bff;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #0056b3;
        }
        .cancel-btn {
            background: #6c757d;
            margin-top: 10px;
            display: block;
            text-align: center;
            padding: 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .cancel-btn:hover {
            background: #5a6268;
        }
        .msg {
            text-align: center;
            margin: 15px 0;
            font-weight: bold;
        }
        .product-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background: #fff;
        }
        .product-table th,
        .product-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .product-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .action-links .edit {
            color: #212529;
            background: #ffc107;
        }
        .action-links .delete {
            color: #fff;
            background: #dc3545;
        }
        .action-links .edit:hover {
            background: #e0a800;
        }
        .action-links .delete:hover {
            background: #c82333;
        }
        @media (max-width: 600px) {
            .container { padding: 15px; }
            .product-table th, .product-table td { padding: 8px; font-size: 14px; }
            header { gap: 8px; padding: 10px 0; }
            header a { padding: 8px 16px; font-size: 14px; }
        }
    </style>
</head>
<body>

<header>
    <a href="add.php" class="btn-dashboard">🏠 Dashboard</a>
    <a href="order.php" class="btn-add">➕ Manage Order</a>
    <a href="acategory.php" class="btn-categories">🗂️ Manage Categories</a>
</header>

<div class="container">
    <h2><?php echo $edit_mode ? 'Edit Product' : 'Add New Product'; ?></h2>

    <?php if ($message): ?>
        <?= $message ?>
    <?php endif; ?>

    <form method="POST">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="update_id" value="<?= htmlspecialchars($edit_data['product_id']) ?>">
        <?php endif; ?>

        <div class="form-group">
            <input type="number" name="category_id" 
                   value="<?= $edit_mode ? htmlspecialchars($edit_data['category_id']) : '' ?>" 
                   placeholder="Category ID" required>
        </div>

        <div class="form-group">
            <input type="text" name="name" 
                   value="<?= $edit_mode ? htmlspecialchars($edit_data['name']) : '' ?>" 
                   placeholder="Product Name" required>
        </div>

        <div class="form-group">
            <textarea name="description" placeholder="Product Description" rows="3"><?= $edit_mode ? htmlspecialchars($edit_data['description']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <input type="number" step="0.01" name="unit_price" 
                   value="<?= $edit_mode ? htmlspecialchars($edit_data['unit_price']) : '' ?>" 
                   placeholder="Unit Price" required>
        </div>

        <div class="form-group">
            <input type="number" name="stock_qty" 
                   value="<?= $edit_mode ? htmlspecialchars($edit_data['stock_qty']) : '' ?>" 
                   placeholder="Stock Quantity" required>
        </div>

        <div class="form-group">
            <!-- ✅ CRITICAL FIX: Added name="submit" -->
            <button type="submit" name="submit">
                <?= $edit_mode ? 'Update Product' : 'Add Product' ?>
            </button>
        </div>

        <?php if ($edit_mode): ?>
            <div class="form-group">
                <a href="add_product.php" class="cancel-btn">Cancel Edit</a>
            </div>
        <?php endif; ?>
    </form>

    <?php if (!$edit_mode): ?>
        <h3 style="margin-top: 40px;">All Products</h3>
        <?php if (mysqli_num_rows($products_result) > 0): ?>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($products_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['product_id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>$<?= number_format($row['unit_price'], 2) ?></td>
                            <td><?= htmlspecialchars($row['stock_qty']) ?></td>
                            <td class="action-links">
                                <a href="?edit_id=<?= urlencode($row['product_id']) ?>" class="edit">✏️ Edit</a>
                                <a href="?delete_id=<?= urlencode($row['product_id']) ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?');">🗑️ Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:#666;">No products found.</p>
        <?php endif; ?>
    <?php endif; ?>

</div>

<?php
mysqli_close($conn);
?>

</body>
</html>