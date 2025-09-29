<?php
// profile.php
require_once __DIR__ . '/init.php';

// bắt buộc phải đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); exit;
}

$userid = intval($_SESSION['user']['id']);
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_info'])) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($name === '' || $email === '') {
            $errors[] = "Vui lòng điền đầy đủ thông tin.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ.";
        } else {
            // kiểm tra email khác user khác đã dùng chưa
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
            $stmt->bind_param("si", $email, $userid);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = "Email đã có người sử dụng.";
            }
            $stmt->close();

            if (empty($errors)) {
                $up = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $up->bind_param("ssi", $name, $email, $userid);
                if ($up->execute()) {
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['user']['email'] = $email;
                    $success = "Cập nhật thông tin thành công.";
                } else $errors[] = "Lỗi cập nhật: " . $conn->error;
            }
        }
    } elseif (isset($_POST['change_pass'])) {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $new2 = $_POST['new_password2'] ?? '';
        if ($current === '' || $new === '') $errors[] = "Vui lòng nhập đầy đủ mật khẩu.";
        elseif ($new !== $new2) $errors[] = "Mật khẩu mới xác nhận không khớp.";
        elseif (strlen($new) < 6) $errors[] = "Mật khẩu mới phải ít nhất 6 ký tự.";
        else {
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row || !password_verify($current, $row['password'])) {
                $errors[] = "Mật khẩu hiện tại không đúng.";
            } else {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $up->bind_param("si", $hash, $userid);
                if ($up->execute()) $success = "Đổi mật khẩu thành công.";
                else $errors[] = "Lỗi khi đổi mật khẩu: " . $conn->error;
            }
        }
    }
}

// lấy thông tin user để hiển thị
$stmt = $conn->prepare("SELECT id, name, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

include 'header.php';
?>
<div class="wrap">
  <h1 class="page-title">Hồ sơ của tôi</h1>
  <?php if ($errors): foreach ($errors as $er) echo '<p class="error">'.e($er).'</p>'; endforeach; ?>
  <?php if ($success) echo '<p class="success">'.e($success).'</p>'; ?>

  <div class="auth-box">
    <form method="post">
      <h3>Thông tin cá nhân</h3>
      <label>Họ và tên</label>
      <input type="text" name="name" value="<?php echo e($user['name']); ?>" required>
      <label>Email</label>
      <input type="email" name="email" value="<?php echo e($user['email']); ?>" required>
      <div class="auth-actions">
        <button class="btn" name="update_info" type="submit">Cập nhật</button>
      </div>
    </form>
  </div>

  <div class="auth-box" style="margin-top:20px">
    <form method="post">
      <h3>Đổi mật khẩu</h3>
      <label>Mật khẩu hiện tại</label>
      <input type="password" name="current_password" required>
      <label>Mật khẩu mới</label>
      <input type="password" name="new_password" required>
      <label>Nhập lại mật khẩu mới</label>
      <input type="password" name="new_password2" required>
      <div class="auth-actions">
        <button class="btn" name="change_pass" type="submit">Đổi mật khẩu</button>
      </div>
    </form>
  </div>
</div>
<?php include 'footer.php'; ?>
