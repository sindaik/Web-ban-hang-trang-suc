<?php
// login.php
require_once __DIR__ . '/init.php';

if (isset($_SESSION['user'])) {
    header('Location: index.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Vui lòng nhập email và mật khẩu.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                // đăng nhập thành công
                $_SESSION['user'] = [
                    'id'    => $row['id'],
                    'name'  => $row['name'],
                    'email' => $email
                ];
                // chuyển hướng với thông báo
                header('Location: index.php?msg=login_success'); exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng.";
            }
        } else {
            $error = "Email hoặc mật khẩu không đúng.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">  
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (file_exists('header.php')) include 'header.php'; ?>
<div class="wrap">
  <div class="auth-box">
    <h2>Đăng nhập</h2>
    <?php if ($error) echo '<p class="error">'.e($error).'</p>'; ?>
    <form method="post" action="login.php">
      <label>Email</label>
      <input type="email" name="email" required>

      <label>Mật khẩu</label>
      <input type="password" name="password" required>

      <div class="auth-actions">
        <button class="btn" type="submit">Đăng nhập</button>
        <a class="btn btn-secondary" href="register.php">Tạo tài khoản</a>
      </div>
    </form>
  </div>
</div>
<?php if (file_exists('footer.php')) include 'footer.php'; ?>
</body>
</html>
