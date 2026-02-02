<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }
        .container {
            width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 25px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        button {
            background: #28a745;
            border: none;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .msg {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Category</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Category Name" required>

        <textarea name="description" placeholder="Category Description"></textarea>

        <button type="submit" name="submit">Add Category</button>
    </form>

    <?php
    include "../connection.php";

    if (isset($_POST['submit'])) {

        $name = $_POST['name'];
        $description = $_POST['description'];

        $sql = "INSERT INTO category (name, description)
                VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $name, $description);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='msg' style='color:green;'>Category Added Successfully!</div>";
            } else {
                echo "<div class='msg' style='color:red;'>Error: " . mysqli_stmt_error($stmt) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='msg' style='color:red;'>Prepare failed: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
</div>

</body>
</html>
