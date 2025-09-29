<?php
session_start();
require_once '../init.php'; 

// Nếu đã đăng nhập admin thì chuyển sang admin/products.php
if (isset($_SESSION['admin_user'])) {
    header('Location: products.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Tài khoản admin cố định theo yêu cầu
    $ADMIN_EMAIL = 'ngocdai2831@gmail.com';
    $ADMIN_PASS  = '123456';

    if ($email === $ADMIN_EMAIL && $password === $ADMIN_PASS) {
        // thành công
        $_SESSION['admin_user'] = $ADMIN_EMAIL;
        header('Location: products.php'); exit;
    } else {
        $error = 'Email hoặc mật khẩu admin không đúng.';
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Admin Login - LiLi</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="wrap">
  <h1 class="page-title">Admin - Đăng nhập</h1>
  <?php if ($error): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>
  <form method="post" class="admin-form">
    <label>Email</label>
    <input type="email" name="email" required value="<?php echo isset($email)?htmlspecialchars($email):''; ?>">
    <label>Mật khẩu</label>
    <input type="password" name="password" required>
    <div class="auth-actions">
      <button class="btn" type="submit">Đăng nhập</button>
      <a class="btn btn-secondary" href="../index.php">Về trang chủ</a>
    </div>
  </form>
</div>
</body>
</html>
