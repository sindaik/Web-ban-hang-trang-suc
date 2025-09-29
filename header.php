<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>[SINDAIK - Premium Jewelry - Trang Sức Cao Cấp] - Bạc, Vàng, Đá Quý</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/script.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<header class="site-header">
  <div class="wrap header-top">
    <div class="logo">
      <a href="index.php"><img src="assets/images/logots.jpg" alt="LiLi" class="logo-img"></a>
    </div>

    <form action="search.php" method="get" class="search-form">
      <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." required>
    </form>

    <div class="header-actions">    
      <!-- Nếu đã đăng nhập -->
      <?php if(isset($_SESSION['user'])): ?>
        <div class="user-box">
          <span>👋 Xin chào, <strong><?php echo htmlspecialchars($_SESSION['user']['name']); ?></strong></span>
          <a href="logout.php" class="btn btn-logout">Đăng xuất</a>
        </div>
      <?php else: ?>
        <!-- Nút mở modal -->
        <button class="dropbtn">👤 Tài khoản</button>
      <?php endif; ?>

      <!-- Modal Đăng nhập / Đăng ký -->
      <div id="authModal" class="modal">
        <div class="modal-content auth-box">
          <span class="close">&times;</span>
          <div class="auth-tabs">
            <button id="loginTab" class="tab active">Đăng nhập</button>
            <button id="registerTab" class="tab">Đăng ký</button>
          </div>

          <!-- Form đăng nhập -->
          <form id="loginForm" action="login.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit" class="btn black-btn">Đăng nhập</button>
          </form>

          <!-- Form đăng ký -->
          <form id="registerForm" action="register.php" method="post" class="hidden">
            <input type="text" name="name" placeholder="Họ tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="password" name="password2" placeholder="Nhập lại mật khẩu" required>
            <button type="submit" class="btn black-btn">Đăng ký</button>
          </form>
        </div>
      </div>

      <!-- Giỏ hàng -->   
      <a href="cart.php" class="cart-btn">
        🛒 Giỏ hàng (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)
      </a>

      <!-- Nút Liên hệ nổi -->
      <div class="contact-float">
        <button id="contactToggle" class="contact-btn">
          <i class="fa-solid fa-bell fa-2x"></i>
          <div class="contact-label">LIÊN HỆ</div>
        </button>
        <div id="contactBox" class="contact-box">
          <a href="tel:0876503755"><i class="fa-solid fa-phone"></i> Gọi: 08765.03755</a>
          <a href="https://zalo.me/0336532136" target="_blank"><i class="fa-brands fa-facebook-messenger"></i> Zalo</a>
          <a href="https://www.facebook.com/sdaik86/" target="_blank"><i class="fa-brands fa-facebook"></i> Facebook</a>
        </div>
      </div>
    </div>
  </div>

  <!-- MENU -->
  <nav class="main-nav">
    <div class="wrap nav-inner">
      <a href="category.php?category=Vòng - Lắc">VÒNG - LẮC</a>
      <a href="category.php?category=Nhẫn">NHẪN</a>
      <a href="category.php?category=Dây Chuyền">DÂY CHUYỀN</a>
      <a href="category.php?category=Bông Tai">BÔNG TAI</a>
      <a href="category.php?category=Khuyên Xỏ">KHUYÊN XỎ</a>
      <a href="category.php?category=Trang Sức Đôi">TRANG SỨC ĐÔI</a>
      <a href="category.php?category=Trang Sức Bộ">TRANG SỨC BỘ</a>
      <a href="category.php?category=Phong Thủy">PHONG THỦY</a>
      <a href="category.php?category=Quà Tặng">QUÀ TẶNG</a>
      <a href="category.php?category=Phụ Kiện">PHỤ KIỆN</a>
      <a href="category.php?category=Sản Phẩm Mới">SẢN PHẨM MỚI</a>
    </div>
  </nav>

  <!-- BEGIN: Slideshow Banner (thay thế site-banner cũ) -->
  <div class="slideshow-container" aria-label="Banner slideshow">
    <div class="mySlides" role="tabpanel">
      <a href="#"><img src="assets/images/banner.jpg" alt="Banner 1" loading="lazy" /></a>
    </div>
    <div class="mySlides" role="tabpanel">
      <a href="#"><img src="assets/images/banner2.jpg" alt="Banner 2" loading="lazy" /></a>
    </div>

    <!-- controls -->
    <button class="prev" aria-label="Previous slide" onclick="plusSlides(-1)">&#10094;</button>
    <button class="next" aria-label="Next slide" onclick="plusSlides(1)">&#10095;</button>
  </div>
  <!-- END: Slideshow Banner -->

</header>

<main class="wrap">
