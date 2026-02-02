<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Products</title>
  <style>
    /* Base styles for full-page layout */
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
    }

    h2 {
      margin: 0 0 30px;
      font-size: 2.2rem;
      font-weight: 600;
      text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    /* Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
      margin-bottom: 30px;
    }

    /* Product Card */
    .product-card {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
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
      display: block;
    }

    .card-body {
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      text-align: left;
      background-color: #ffcccc;
    }

    .card-title {
      font-size: 1.15rem;
      font-weight: 700;
      color: #222;
      line-height: 1.3;
    }

    .card-price {
      font-size: 1.1rem;
      font-weight: 800;
      color: #28a745; /* Green for price */
    }

    .card-description {
      font-size: 0.95rem;
      color: #555;
      line-height: 1.5;
      flex: 1;
    }

    .card-id {
      font-size: 0.85rem;
      color: #888;
      margin-top: 4px;
    }

    /* No products message */
    .no-products {
      grid-column: 1 / -1;
      padding: 20px;
      color: #ff6b6b;
      font-weight: 600;
      text-align: center;
      border: 1px dashed #ffcccc;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(4px);
    }

    /* Back button */
    .back-btn {
      display: inline-block;
      text-decoration: none;
      background: #28a745;
      color: white;
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1rem;
      transition: background 0.3s;
    }

    .back-btn:hover {
      background: #218838;
    }

    /* Responsive: on small screens, 1 or 2 columns */
    @media (max-width: 768px) {
      .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
      }

      h2 {
        font-size: 1.8rem;
      }
    }

    @media (max-width: 480px) {
      .product-grid {
        grid-template-columns: 1fr;
      }

      body {
        padding: 20px 15px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2 style="color: white;">All Products</h2>

    <div class="product-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM product");

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $img = !empty($row['image']) ? $row['image'] : "https://via.placeholder.com/300x200?text=No+Image";
          echo "
            <div class='product-card'>
              <div class='card-image'>
                <img src='{$img}' alt='Product Image'>
              </div>
              <div class='card-body'>
                <div class='card-title'>{$row['name']}</div>
                <div class='card-price'>€ {$row['unit_price']}</div>
                <div class='card-description'>{$row['description']}</div>
                <div class='card-id'>Product ID: {$row['product_id']}</div>
              </div>
            </div>
          ";
        }
      } else {
        echo "<div class='no-products'>No Products Found</div>";
      }
      ?>
    </div>

   
  </div>

</body>
</html>