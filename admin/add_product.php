<?php
session_start();
require_once '../init.php';
require_once '../db.php';
if (!isset($_SESSION['admin_user'])) { header('Location: login.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $discount = intval($_POST['discount'] ?? 0);

    // xử lý upload
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) $error = 'Ảnh không hợp lệ.';
        else {
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\-\_\.]/','', $fileName);
            move_uploaded_file($fileTmp, __DIR__ . '/../assets/images/' . $imageName);
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO products (name,category,description,price,discount,image,created_at) VALUES (?,?,?,?,?,?,NOW())");
        $stmt->bind_param("ssdiss", $name, $category, $desc, $price, $discount, $imageName);
        if ($stmt->execute()) {
            header('Location: products.php'); exit;
        } else $error = 'Lỗi khi thêm: ' . $conn->error;
    }
}
?>
<!doctype html><html lang="vi"><head><meta charset="utf-8"><title>Thêm sản phẩm</title>
<link rel="stylesheet" href="../assets/css/style.css"></head><body>
<div class="wrap">
  <h1 class="page-title">Thêm sản phẩm mới</h1>
  <?php if ($error) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
  <form method="post" enctype="multipart/form-data" class="admin-form">
    <label>Tên sản phẩm</label><input type="text" name="name" required>
    <label>Danh mục</label><input type="text" name="category" required placeholder="Nhẫn / Dây Chuyền ...">
    <label>Mô tả</label><textarea name="description"></textarea>
    <label>Giá (VNĐ)</label><input type="number" name="price" required step="1000" min="0">
    <label>Giảm giá (%)</label><input type="number" name="discount" value="0" min="0" max="100">
    <label>Ảnh</label><input type="file" name="image" accept="image/*">
    <div class="auth-actions">
      <button class="btn" type="submit">Thêm</button>
      <a class="btn btn-secondary" href="products.php">Hủy</a>
    </div>
  </form>
</div>
</body></html>
