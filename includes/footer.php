
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page with Independent Footer</title>

  <!-- Font Awesome (optional, for icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    /* ===== BASIC PAGE STYLES (SAFE) ===== */
    body{
      margin:0;
      font-family:Arial, sans-serif;
      min-height:100vh;
      display:flex;
      flex-direction:column;
    }

    main{
      flex:1;
      padding:40px 20px;
    }

    /* ===== INDEPENDENT FOOTER ===== */
    .site-footer{
      width:100%;
      background:#1a1a1a;
      color:#ddd;
      padding:40px 0 20px;
    }

    .site-footer .footer-container{
      width:90%;
      max-width:1200px;
      margin:0 auto;
    }

    .site-footer .footer-content{
      display:flex;
      flex-wrap:wrap;
      gap:30px;
      justify-content:space-between;
    }

    .site-footer .footer-section{
      flex:1;
      min-width:200px;
    }

    .site-footer h3{
      color:#fff;
      margin-bottom:15px;
      font-size:1.2rem;
    }

    .site-footer p,
    .site-footer li,
    .site-footer a{
      color:#bbb;
      text-decoration:none;
      transition:color 0.3s;
    }

    .site-footer a:hover{
      color:#4da6ff;
    }

    .site-footer ul{
      list-style:none;
      margin-top:10px;
      padding:0;
    }

    .site-footer ul li{
      margin-bottom:8px;
    }

    .site-footer .social-links{
      display:flex;
      gap:12px;
      margin-top:15px;
    }

    .site-footer .social-links a{
      width:36px;
      height:36px;
      background:#333;
      color:#fff;
      border-radius:50%;
      display:flex;
      align-items:center;
      justify-content:center;
      transition:background 0.3s;
    }

    .site-footer .social-links a:hover{
      background:#4da6ff;
    }

    .site-footer .footer-bottom{
      text-align:center;
      padding-top:20px;
      margin-top:30px;
      border-top:1px solid #333;
      color:#888;
      font-size:0.9rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width:768px){
      .site-footer .footer-content{
        flex-direction:column;
        gap:25px;
      }
      .site-footer .footer-container{
        width:95%;
      }
    }
  </style>
</head>
<body>

  <footer class="site-footer">
    <div class="footer-container">

      <div class="footer-content">
        <div class="footer-section">
          <h3>ShopName</h3>
          <p>Your trusted online store for quality products at affordable prices.</p>

          <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <div class="footer-section">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h3>Contact</h3>
          <p>📍 123 Main St, City</p>
          <p>📞 +1 (555) 123-4567</p>
          <p>✉️ info@shopname.com</p>
        </div>
      </div>

      <div class="footer-bottom">
        &copy; 2026 ShopName. All rights reserved.
      </div>

    </div>
  </footer>

</body>
</html>
