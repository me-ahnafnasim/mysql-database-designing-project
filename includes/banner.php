<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop Banner</title>

<style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* BANNER */
.banner {
    width: 100%;
    height: 420px; /* 👈 fixed banner height */
    background: linear-gradient(135deg, #1a2530, #2c3e50);
    display: flex;
    align-items: center;
}

/* INNER CONTAINER */
.banner-container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
}

/* TEXT SIDE */
.banner-content {
    flex: 1;
    color: white;
}

.banner-content h1 {
    font-size: 42px;
    margin-bottom: 15px;
}

.banner-content h1 span {
    color: #3498db;
}

.banner-content p {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 25px;
    color: #ecf0f1;
}

.banner-btn {
    display: inline-block;
    padding: 14px 32px;
    background: #3498db;
    color: white;
    text-decoration: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.3s;
}

.banner-btn:hover {
    background: #2980b9;
}

/* IMAGE SIDE */
.banner-image {
    flex: 1;
    display: flex;
    justify-content: center;
}

.banner-image img {
    width: 100%;
    max-width: 480px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .banner {
        height: auto;
        padding: 60px 0;
    }

    .banner-container {
        flex-direction: column;
        text-align: center;
    }

    .banner-content h1 {
        font-size: 32px;
    }

    .banner-image img {
        max-width: 360px;
    }
}
</style>
</head>

<body>

<section class="banner">
    <div class="banner-container">

        <!-- TEXT -->
        <div class="banner-content">
            <h1>Best Deals for Your <span>Shop</span></h1>
            <p>
                Discover high-quality products at unbeatable prices.
                Upgrade your business with our premium collections.
            </p>
            <a href="product.php" class="banner-btn">Shop Now</a>
        </div>

        <!-- IMAGE -->
        <div class="banner-image">
            <img src="https://images.unsplash.com/photo-1607082350899-7e105aa886ae" alt="Shop Banner">
        </div>

    </div>
</section>

</body>
</html>
