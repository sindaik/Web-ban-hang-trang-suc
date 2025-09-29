<?php
// product.php - hiển thị chi tiết sản phẩm (đã loại bỏ Mã SP và Ngày đăng)

require 'init.php';
include 'header.php';

// helper escape nếu chưa có
if (!function_exists('e')) {
    function e($v) { return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    echo "<div class='wrap'><p>Sản phẩm không hợp lệ hoặc không tồn tại. <a href='index.php'>Về trang chủ</a></p></div>";
    include 'footer.php';
    exit;
}

// Lấy sản phẩm
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
if ($stmt === false) {
    echo "<div class='wrap'><p>Lỗi truy vấn: " . e($conn->error) . "</p></div>";
    include 'footer.php';
    exit;
}
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$p = $res ? $res->fetch_assoc() : null;
$stmt->close();

if (!$p) {
    echo "<div class='wrap'><p>Sản phẩm không tồn tại. <a href='index.php'>Về trang chủ</a></p></div>";
    include 'footer.php';
    exit;
}

// Ảnh (fallback)
$img = !empty($p['image']) ? $p['image'] : 'no-image.png';
$imgPath = "assets/images/" . $img;
if (!file_exists($imgPath)) $imgPath = "assets/images/no-image.png";

// Giá sau giảm
$discount = intval($p['discount'] ?? 0);
$price = floatval($p['price'] ?? 0);
$finalPrice = $price * (1 - ($discount / 100));
?>

<main class="wrap">
  <div class="product-detail" style="margin-top:18px;">
    <div class="col-left">
      <img src="<?php echo e($imgPath); ?>" alt="<?php echo e($p['name']); ?>">
    </div>

    <div class="col-right">
      <p style="margin:0 0 8px;color:#666;font-weight:600;"><?php echo e($p['category'] ?: 'Chưa có danh mục'); ?></p>
      <h1 style="margin:0 0 12px;"><?php echo e($p['name']); ?></h1>

      <div style="margin-bottom:10px;">
        <?php if ($discount > 0): ?>
          <div style="display:flex;gap:10px;align-items:center;">
            <div style="font-size:14px;color:#777;text-decoration:line-through;">
              <?php echo number_format($price,0,',','.'); ?> ₫
            </div>
            <div style="font-size:20px;font-weight:800;color:var(--brand);">
              <?php echo number_format($finalPrice,0,',','.'); ?> ₫
            </div>
            <div style="background:var(--primary);color:#fff;padding:4px 8px;border-radius:6px;font-weight:700;">
              -<?php echo $discount; ?>%
            </div>
          </div>
        <?php else: ?>
          <div style="font-size:20px;font-weight:800;color:var(--brand);margin-bottom:8px;">
            <?php echo number_format($price,0,',','.'); ?> ₫
          </div>
        <?php endif; ?>
      </div>

      <h3 style="margin-top:12px;margin-bottom:6px;color:#333;">Mô tả sản phẩm</h3>
      <div style="margin-bottom:14px;color:#444;line-height:1.6;">
        <?php
          // hiển thị mô tả (bảo mật XSS)
          echo nl2br(e($p['description'] ?: 'Chưa có mô tả cho sản phẩm này.'));
        ?>
      </div>

      <form action="cart.php" method="get" class="product-actions" style="margin-top:0;">
         <input type="hidden" name="action" value="add">
         <input type="hidden" name="id" value="<?php echo intval($p['id']); ?>">

         <label for="qty" style="font-weight:600;margin-right:6px;">Số lượng:</label>
         <input id="qty" class="qty" type="number" name="qty" value="1" min="1">

         <button class="btn" type="submit">Thêm vào giỏ</button>
         <a class="btn btn-secondary" href="javascript:history.back()">Quay lại</a>
      </form>

    </div>
  </div>
</main>

<?php include 'footer.php'; ?>
