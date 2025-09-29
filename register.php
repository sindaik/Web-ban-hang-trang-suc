<?php
// register.php
require_once __DIR__ . '/init.php';

// nếu đã đăng nhập thì chuyển về trang chủ
if (isset($_SESSION['user'])) {
    header('Location: index.php'); exit;
}

$errors = [];
$name = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // validate
    if ($name === '' || $email === '' || $password === '') {
        $errors[] = "Vui lòng điền đầy đủ thông tin.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    } elseif ($password !== $password2) {
        $errors[] = "Mật khẩu xác nhận không khớp.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else {
        // kiểm tra email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email này đã được sử dụng.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $ins = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $ins->bind_param("sss", $name, $email, $hash);
        if ($ins->execute()) {
            $userid = $conn->insert_id;
            // lưu session user (ít thông tin, không lưu mật khẩu)
            $_SESSION['user'] = [
                'id'    => $userid,
                'name'  => $name,
                'email' => $email
            ];
            // chuyển hướng với thông báo
            header('Location: index.php?msg=register_success'); exit;
        } else {
            $errors[] = "Lỗi khi tạo tài khoản: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (file_exists('header.php')) include 'header.php'; ?>
<div class="wrap">
  <div class="auth-box">
    <h2>Đăng ký tài khoản</h2>
    <?php if ($errors): ?>
      <div class="error">
      <?php foreach ($errors as $er) echo '<p>'.e($er).'</p>'; ?>
      </div>
    <?php endif; ?>
    <form method="post" action="register.php">
      <label>Họ và tên</label>
      <input type="text" name="name" required value="<?php echo e($name); ?>">

      <label>Email</label>
      <input type="email" name="email" required value="<?php echo e($email); ?>">

      <label>Mật khẩu</label>
      <input type="password" name="password" required>

      <label>Nhập lại mật khẩu</label>
      <input type="password" name="password2" required>

      <div class="auth-actions">
        <button class="btn" type="submit">Đăng ký</button>
        <a class="btn btn-secondary" href="login.php">Đã có tài khoản? Đăng nhập</a>
      </div>
    </form>
  </div>
</div>
<?php if (file_exists('footer.php')) include 'footer.php'; ?>
</body>
</html>
