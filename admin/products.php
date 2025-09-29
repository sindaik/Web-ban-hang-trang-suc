<?php
// admin/products.php
session_start();
require_once '../init.php';
require_once '../db.php';

if (!isset($_SESSION['admin_user'])) {
    header('Location: login.php'); exit;
}

// xử lý update price/discount (form POST nhỏ mỗi dòng)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'update_price') {
        $id = intval($_POST['id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $discount = intval($_POST['discount'] ?? 0);
        $stmt = $conn->prepare("UPDATE products SET price = ?, discount = ? WHERE id = ?");
        $stmt->bind_param("dii", $price, $discount, $id);
        $stmt->execute();
        header('Location: products.php'); exit;
    }

    if ($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        // xóa file ảnh nếu có
        $q = $conn->prepare("SELECT image FROM products WHERE id = ?");
        $q->bind_param("i",$id); $q->execute();
        $r = $q->get_result()->fetch_assoc();
        if ($r && $r['image']) {
            @unlink(__DIR__ . '/../assets/images/' . $r['image']);
        }
        $d = $conn->prepare("DELETE FROM products WHERE id = ?");
        $d->bind_param("i",$id); $d->execute();
        header('Location: products.php'); exit;
    }
}

// lấy danh sách
$res = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Admin - Quản lý sản phẩm</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .admin-top { display:flex; justify-content:space-between; align-items:center; margin:20px 0; }
    table.admin-table { width:100%; border-collapse:collapse; }
    table.admin-table th, table.admin-table td { padding:8px; border:1px solid #ddd; text-align:left; vertical-align:top; }
    .small-form input[type="number"], .small-form input[type="text"]{ width:110px; padding:6px; }
    .img-thumb { width:80px; height:80px; object-fit:cover; border-radius:6px; }
  </style>
</head>
<body>
<div class="wrap">
  <div class="admin-top">
    <h1 class="page-title">Quản lý sản phẩm</h1>
    <div>
      <a class="btn" href="add_product.php">Thêm sản phẩm</a>
      <a class="btn btn-secondary" href="logout.php">Đăng xuất</a>
    </div>
  </div>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Giá (₫)</th><th>Giảm (%)</th><th>Giá sau giảm</th><th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($products): foreach ($products as $p): 
        $final = $p['price'] * (1 - (intval($p['discount'])/100));
      ?>
      <tr>
        <td><?php echo $p['id']; ?></td>
        <td><img class="img-thumb" src="../assets/images/<?php echo htmlspecialchars($p['image'] ?: 'no-image.png'); ?>" alt=""></td>
        <td><?php echo htmlspecialchars($p['name']); ?></td>
        <td><?php echo htmlspecialchars($p['category']); ?></td>
        <td>
          <form class="small-form" method="post" style="display:inline-block">
            <input type="hidden" name="action" value="update_price">
            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
            <input type="number" name="price" value="<?php echo htmlspecialchars($p['price']); ?>" step="1000" min="0">
        </td>
        <td>
            <input type="number" name="discount" value="<?php echo htmlspecialchars($p['discount']); ?>" min="0" max="100"> %
        </td>
        <td>
            <?php echo number_format($final,0,',','.'); ?> ₫
        </td>
        <td>
            <button class="btn" type="submit">Lưu</button>
            </form>
            <a class="btn btn-secondary" href="edit_product.php?id=<?php echo $p['id']; ?>">Sửa</a>

            <form method="post" style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
              <button class="btn btn-secondary" type="submit">Xóa</button>
            </form>
        </td>
      </tr>
      <?php endforeach; else: ?>
      <tr><td colspan="8">Chưa có sản phẩm nào.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
