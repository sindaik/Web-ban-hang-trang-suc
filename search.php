<?php
require 'init.php';
include 'header.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q == '') {
    echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
    include 'footer.php';
    exit;
}
$like = "%$q%";
$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY created_at DESC");
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$res = $stmt->get_result();
?>
<h1 class="page-title">Kết quả tìm kiếm: <?php echo e($q); ?></h1>

<div class="product-grid">
<?php while ($p = $res->fetch_assoc()): ?>
  <div class="card">
    <img src="assets/images/<?php echo e($p['image'] ?: 'no-image.png'); ?>" alt="<?php echo e($p['name']); ?>">
    <div class="card-body">
      <h3><?php echo e($p['name']); ?></h3>
      <p class="price"><?php echo number_format($p['price'],0,',','.'); ?> ₫</p>
      <a class="btn" href="product.php?id=<?php echo $p['id']; ?>">Chi tiết</a>
      <a class="btn btn-secondary" href="cart.php?action=add&id=<?php echo $p['id']; ?>">Thêm vào giỏ</a>
    </div>
  </div>
<?php endwhile; ?>  
</div>

<?php include 'footer.php'; ?>
