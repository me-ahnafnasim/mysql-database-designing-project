
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Row Header</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* RESET */
body{
    background: linear-gradient(135deg, #1a2530, #2c3e50);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* HEADER */
.header {
    width: 100%;
    height: 80px; /* 👈 fixed height */
    background: linear-gradient(90deg, #2c3e50 0%, #1a2530 100%);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

/* INNER CONTAINER */
.header-container {
    max-width: 1200px;
    height: 100%;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* LOGO */
.logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo-icon {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 22px;
}

.logo-text {
    color: white;
    font-size: 24px;
    font-weight: 700;
}

.logo-text span {
    color: #3498db;
}

/* NAVIGATION */
.nav-menu {
    list-style: none;
    display: flex;
    gap: 28px;
}

.nav-menu a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    position: relative;
}

.nav-menu a:hover,
.nav-menu a.active {
    color: #3498db;
}

.nav-menu a::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0;
    height: 2px;
    background: #3498db;
    transition: width 0.3s;
}

.nav-menu a:hover::after,
.nav-menu a.active::after {
    width: 100%;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .nav-menu {
        gap: 16px;
    }

    .logo-text {
        font-size: 20px;
    }
}
</style>
</head>

<body>

<header class="header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <div class="logo-icon">
                <i class="fab fa-php"></i>
            </div>
            <div class="logo-text">ahnaf<span>baba</span></div>
        </div>

        <!-- Navigation -->
        <ul class="nav-menu">
            <li><a href="#" >Home</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li>
  <a href="/ecommerce/dashboard/add.php"
     style="
       background:#28a745;
       color:#ffffff;
       padding:8px 16px;
       border-radius:6px;
       font-weight:600;
       text-decoration:none;
       display:inline-block;
       transition:0.3s;
     "
     onmouseover="this.style.background='#218838'"
     onmouseout="this.style.background='#28a745'"
  >
    Dashboard
  </a>
</li>


        </ul>
    </div>
</header>

</body>
</html>
