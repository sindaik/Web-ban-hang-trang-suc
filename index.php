<?php
require 'init.php';
include 'header.php';

// Thiết lập phân trang
$perPage = 8;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Lấy sản phẩm
$stmt = $conn->prepare("
    SELECT SQL_CALC_FOUND_ROWS * 
    FROM products 
    ORDER BY created_at DESC 
    LIMIT ?, ?
");
$stmt->bind_param("ii", $offset, $perPage);
$stmt->execute();
$res = $stmt->get_result();
$products = $res->fetch_all(MYSQLI_ASSOC);

// Tổng số sản phẩm
$totalRes = $conn->query("SELECT FOUND_ROWS() as total")->fetch_assoc();
$total = $totalRes ? intval($totalRes['total']) : 0;
$pages = max(1, ceil($total / $perPage));
?>

<main class="wrap">
  <!-- Tiêu đề chính -->
  <h1 class="page-title section-title"><span>SẢN PHẨM NỔI BẬT</span></h1>

  <?php if ($products): ?>
    <div class="product-grid">
      <?php foreach ($products as $p): ?>
        <div class="card">
          <a href="product.php?id=<?php echo $p['id']; ?>">
            <img 
              src="assets/images/<?php echo e($p['image'] ?: 'no-image.png'); ?>" 
              alt="<?php echo e($p['name']); ?>"
              loading="lazy"
            >
          </a>
          <div class="card-body">
            <h3><?php echo e($p['name']); ?></h3>
            <p class="price"><?php echo number_format($p['price'],0,',','.'); ?> ₫</p>
            <div class="card-actions">
              <a class="btn" href="product.php?id=<?php echo $p['id']; ?>">Chi tiết</a>
              <a 
                class="btn btn-secondary add-to-cart" 
                href="cart.php?action=add&id=<?php echo $p['id']; ?>"
              >
                Thêm vào giỏ
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>⛔ Hiện chưa có sản phẩm nào.</p>
  <?php endif; ?>

  <!-- Pagination -->
  <?php if ($pages > 1): ?>
    <div class="pagination">
      <?php for ($i=1;$i<=$pages;$i++): ?>
        <a 
          class="<?php echo $i==$page ? 'active' : ''; ?>" 
          href="index.php?page=<?php echo $i; ?>"
        >
          <?php echo $i; ?>
        </a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // Lấy msg từ PHP (nếu có)
  const msg = <?php echo isset($_GET['msg']) ? json_encode($_GET['msg']) : 'null'; ?>;

  if (msg) {
    // Hiển thị popup theo msg
    if (msg === 'order_complete' || msg === 'order_success') {
      Swal.fire({
        title: '🎉 Đặt hàng thành công!',
        text: 'Cảm ơn bạn đã mua hàng. Vui lòng chờ vận chuyển!',
        icon: 'success',
        confirmButtonText: 'OK'
      });
    } else if (msg === 'login_success') {
      Swal.fire({
        title: '✅ Đăng nhập thành công!',
        text: 'Chào mừng bạn quay trở lại!',
        icon: 'success',
        confirmButtonText: 'OK'
      });
    } else if (msg === 'register_success' || msg === 'welcome') {
      Swal.fire({
        title: '🎉 Đăng ký thành công!',
        text: 'Tài khoản của bạn đã được tạo. Hãy trải nghiệm mua sắm ngay!',
        icon: 'success',
        confirmButtonText: 'Bắt đầu'
      });
    } else if (msg === 'login_fail') {
      // (tuỳ chọn) nếu bạn muốn xử lý thông báo lỗi login, giữ ví dụ này
      Swal.fire({
        title: '⚠️ Thông báo',
        text: 'Có vấn đề xảy ra. Vui lòng thử lại.',
        icon: 'warning',
        confirmButtonText: 'OK'
      });
    }

    // Xóa tham số msg khỏi URL để không hiển thị lại khi reload
    try {
      const u = new URL(window.location.href);
      u.searchParams.delete('msg');
      // nếu chỉ còn page param (hoặc khác), giữ nguyên; thay đổi lịch sử để URL sạch
      history.replaceState(null, '', u.pathname + (u.search ? '?' + u.searchParams.toString() : ''));
    } catch (e) {
      // fallback: replaceState đơn giản
      const clean = window.location.pathname;
      history.replaceState(null, '', clean);
    }
  }

  // Xác nhận khi thêm vào giỏ (giữ behavior cũ)
  document.querySelectorAll(".add-to-cart").forEach(btn => {
    btn.addEventListener("click", function(e) {
      const ok = confirm("🛒 Bạn có chắc muốn thêm sản phẩm này vào giỏ?");
      if (!ok) e.preventDefault();
    });
  });

  // Hiệu ứng hover nút
  document.querySelectorAll(".btn").forEach(btn => {
    btn.addEventListener("mouseenter", () => btn.style.opacity = "0.85");
    btn.addEventListener("mouseleave", () => btn.style.opacity = "1");
  });
});
</script>
