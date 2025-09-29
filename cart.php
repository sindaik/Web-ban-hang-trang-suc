<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require 'init.php';
if (!isset($conn) || !$conn) {
    if (file_exists(__DIR__ . '/db.php')) require_once __DIR__ . '/db.php';
    elseif (file_exists(__DIR__ . '/../db.php')) require_once __DIR__ . '/../db.php';
}

// đảm bảo cart tồn tại
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// ========== ACTION ==========
$action = $_REQUEST['action'] ?? '';

if ($action === 'add' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $qty = isset($_GET['qty']) ? max(1, intval($_GET['qty'])) : 1;
    if ($id > 0) {
        if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id] += $qty;
        else $_SESSION['cart'][$id] = $qty;
    }
    header('Location: cart.php'); exit;
}
if ($action === 'remove' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($id > 0 && isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
    header('Location: cart.php'); exit;
}
if ($action === 'clear') {
    $_SESSION['cart'] = [];
    header('Location: cart.php'); exit;
}
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['qty'] as $idStr => $q) {
        $id = intval($idStr);
        $q = max(0, intval($q));
        if ($q <= 0) unset($_SESSION['cart'][$id]);
        else $_SESSION['cart'][$id] = $q;
    }
    header('Location: cart.php'); exit;
}

include 'header.php';
if (!function_exists('e')) {
    function e($v) { return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
}
?>
<h1 class="page-title">Giỏ hàng</h1>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'order_complete'): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const popup = document.createElement("div");
    popup.className = "order-popup";
    popup.innerHTML = `
        <div class="popup-content">
            🎉 Đơn hàng của bạn đã được đặt thành công!<br>
            Vui lòng chờ giao hàng.
            <button class="close-btn">OK</button>
        </div>
    `;
    document.body.appendChild(popup);
    popup.querySelector(".close-btn").addEventListener("click", () => popup.remove());
});
</script>
<?php endif; ?>

<?php if (empty($_SESSION['cart'])): ?>
  <p>Giỏ hàng đang trống. <a href="index.php">Mua ngay</a></p>
<?php else: ?>
  <form method="post" action="cart.php?action=update">
  <table class="cart-table">
    <tr><th>Ảnh</th><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th><th></th></tr>
    <?php
    $total = 0;
    foreach ($_SESSION['cart'] as $pid => $qty):
        $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$r) continue;
        $line = $r['price'] * $qty;
        $total += $line;
    ?>
    <tr>
      <td><img src="assets/images/<?php echo e($r['image'] ?: 'no-image.png'); ?>" width="60"></td>
      <td><?php echo e($r['name']); ?></td>
      <td><input type="number" name="qty[<?php echo $r['id']; ?>]" value="<?php echo $qty; ?>" min="0" style="width:70px"></td>
      <td><?php echo number_format($r['price'],0,',','.'); ?> ₫</td>
      <td><?php echo number_format($line,0,',','.'); ?> ₫</td>
      <td><a href="cart.php?action=remove&id=<?php echo $r['id']; ?>">Xóa</a></td>
    </tr>
    <?php endforeach; ?>
    <tr><td colspan="4" style="text-align:right"><strong>Tổng cộng:</strong></td>
        <td><strong><?php echo number_format($total,0,',','.'); ?> ₫</strong></td><td></td></tr>
  </table>
  <div class="cart-actions">
    <button type="submit" class="btn">Cập nhật</button>
    <a class="btn btn-secondary" href="cart.php?action=clear">Xóa giỏ hàng</a>
    <a class="btn" href="checkout.php">Tiến hành thanh toán</a>
  </div>
  </form>
<?php endif; ?>

<?php
// ========== LỊCH SỬ ==========
if (isset($_SESSION['last_order_email'])) {
    $userEmail = $_SESSION['last_order_email'];
    echo '<div class="order-history"><h2>Lịch sử mua hàng</h2>';
    echo '<div class="order-history-list">';

    $q = $conn->prepare("SELECT * FROM orders WHERE email = ? ORDER BY id DESC");
    $q->bind_param("s", $userEmail);
    $q->execute();
    $ordersResult = $q->get_result();
    $q->close();

    if ($ordersResult->num_rows > 0) {
        while ($order = $ordersResult->fetch_assoc()) {
            $orderId   = $order['id'];
            $orderDate = $order['created_at'] ?? 'N/A';
            $orderTotal= $order['total'];

            $highlight = ($_SESSION['last_order_id'] == $orderId) ? " highlight" : "";
            echo "<div class='order-card{$highlight}'>";
            echo "<h3>Đơn hàng #".e($orderId)." — Ngày: ".e($orderDate)." — Tổng: <strong>".number_format($orderTotal,0,',','.')." ₫</strong></h3>";

            $q2 = $conn->prepare("SELECT oi.*, p.name AS pname FROM order_items oi LEFT JOIN products p ON oi.product_id=p.id WHERE oi.order_id=?");
            $q2->bind_param("i", $orderId);
            $q2->execute();
            $items = $q2->get_result();
            $q2->close();

            echo "<ul class='order-items'>";
            while ($it = $items->fetch_assoc()) {
                $pname = $it['pname'] ?? 'Sản phẩm';
                $pqty  = $it['qty'];
                $pprice= $it['price'];
                echo "<li>".e($pname)." × ".intval($pqty)." — ".number_format($pprice,0,',','.')." ₫</li>";
            }
            echo "</ul></div>";
        }
    } else {
        echo "<p>Bạn chưa có đơn hàng nào trước đây.</p>";
    }
    echo '</div>'; // đóng order-history-list
    echo '</div>'; // đóng order-history
}
?>

<style>
.order-popup {position: fixed;top:0;left:0;right:0;bottom:0;background: rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;}
.order-popup .popup-content {background:#fff;padding:20px 30px;border-radius:10px;text-align:center;font-size:16px;box-shadow:0 5px 15px rgba(0,0,0,0.3);animation: popin 0.3s ease;}
.order-popup .close-btn {margin-top:15px;padding:8px 16px;border:none;background:#b88f6a;color:#fff;border-radius:5px;cursor:pointer;}
@keyframes popin {from{transform:scale(0.7);opacity:0;}to{transform:scale(1);opacity:1;}}

.order-history { margin-top:28px; }
.order-history h2 { font-size:18px; color:#d10024; margin-bottom:12px; }

.order-history-list {
  max-height: 300px;       /* giới hạn chiều cao */
  overflow-y: auto;        /* thêm scrollbar */
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 6px;
  background: #fafafa;
  margin-bottom: 10px;
}
.order-history-list::-webkit-scrollbar { width: 8px; }
.order-history-list::-webkit-scrollbar-thumb { background: #b88f6a; border-radius: 4px; }
.order-history-list::-webkit-scrollbar-track { background: #f1f1f1; }

.order-card { border:1px solid #eee; padding:14px; margin-bottom:14px; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
.order-card h3 { margin:0 0 10px; font-size:15px; color:#333; }
.order-card .order-items { margin:0 0 0 18px; padding:0; list-style:disc; }
.order-card .order-items li { margin-bottom:6px; font-size:14px; color:#444; }
.order-card.highlight { background:#f9f9ff; border-color:#b88f6a; }
</style>

<?php include 'footer.php'; ?>
