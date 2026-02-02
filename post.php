<?php
include "Connection.php";


if (isset($_POST['submit'])) {

    $product_id  = $_POST['product_id'];
    $name        = $_POST['name'];
    $price       = $_POST['price'];
    $description = $_POST['description'];

    $sql = "INSERT INTO products (product_id, name, price, description)
            VALUES ('$product_id', '$name', '$price', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green; text-align:center;'>Inserted Successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body style="margin:0; font-family: Arial, sans-serif; background: #f4f4f4;">

<div style="display:flex; justify-content:center; align-items:center; height:100vh;">

    <form method="POST" style="
        background: white;
        padding: 30px;
        width: 400px;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
    ">

        <h2 style="text-align:center; margin-bottom:20px;">Add Product</h2>

        <label style="font-weight:bold;">Product ID</label>
        <input type="number" name="product_id" required style="width:100%; padding:10px; margin:5px 0 15px;">

        <label style="font-weight:bold;">Name</label>
        <input type="text" name="name" required style="width:100%; padding:10px; margin:5px 0 15px;">

        <label style="font-weight:bold;">Price</label>
        <input type="text" name="price" required style="width:100%; padding:10px; margin:5px 0 15px;">

        <label style="font-weight:bold;">Description</label>
        <textarea name="description" required style="width:100%; padding:10px; margin:5px 0 15px; height:80px;"></textarea>

        <!-- ✅ Submit button MUST have name="submit" for isset -->
        <button type="submit" name="submit" style="
            width: 100%;
            padding: 12px;
            background: green;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        ">
            Insert
        </button>

    </form>

</div>

</body>
</html>
