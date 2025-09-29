<?php
session_start();
require_once '../init.php';
require_once '../db.php';
if (!isset($_SESSION['admin_user'])) { header('Location: login.php'); exit; }

$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: products.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) { echo "Không tìm thấy sản phẩm."; exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $discount = intval($_POST['discount'] ?? 0);

    $imageName = $product['image'];
    if (!empty($_FILES['image']['name'])) {
        // upload mới
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) $error = 'Ảnh không hợp lệ.';
        else {
            // xóa cũ
            if ($imageName && file_exists(__DIR__ . '/../assets/images/' . $imageName)) @unlink(__DIR__ . '/../assets/images/' . $imageName);
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\-\_\.]/','', $fileName);
            move_uploaded_file($fileTmp, __DIR__ . '/../assets/images/' . $imageName);
        }
    }

    if (!$error) {
        $u = $conn->prepare("UPDATE products SET name=?,category=?,description=?,price=?,discount=?,image=? WHERE id=?");
        $u->bind_param("sssdisi", $name, $category, $desc, $price, $discount, $imageName, $id);
        if ($u->execute()) {
            header('Location: products.php'); exit;
        } else $error = 'Lỗi cập nhật: ' . $conn->error;
    }
}
?>
<!doctype html><html lang="vi"><head><meta charset="utf-8"><title>Sửa sản phẩm</title>
<link rel="stylesheet" href="../assets/css/style.css"></head><body>
<div class="wrap">
  <h1 class="page-title">Sửa sản phẩm</h1>
  <?php if ($error) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
  <form method="post" enctype="multipart/form-data" class="admin-form">
    <label>Tên sản phẩm</label><input type="text" name="name" required value="<?php echo htmlspecialchars($product['name']); ?>">
    <label>Danh mục</label><input type="text" name="category" required value="<?php echo htmlspecialchars($product['category']); ?>">
    <label>Mô tả</label><textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
    <label>Giá (VNĐ)</label><input type="number" name="price" required step="1000" min="0" value="<?php echo htmlspecialchars($product['price']); ?>">
    <label>Giảm giá (%)</label><input type="number" name="discount" min="0" max="100" value="<?php echo htmlspecialchars($product['discount']); ?>">
    <label>Ảnh hiện tại</label><br>
    <img src="../assets/images/<?php echo htmlspecialchars($product['image'] ?: 'no-image.png'); ?>" width="140" style="border-radius:6px"><br><br>
    <label>Thay ảnh (nếu muốn)</label><input type="file" name="image" accept="image/*">
    <div class="auth-actions">
      <button class="btn" type="submit">Cập nhật</button>
      <a class="btn btn-secondary" href="products.php">Hủy</a>
    </div>
  </form>
</div>
</body></html>
