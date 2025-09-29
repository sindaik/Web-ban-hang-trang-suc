<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require 'init.php';

if (empty($_SESSION['cart'])) {
    header('Location: cart.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // lấy thông tin khách
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);

    // tính tổng
    $total = 0;
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $stmt = $conn->prepare("SELECT price FROM products WHERE id=?");
        $stmt->bind_param("i",$pid);
        $stmt->execute();
        $price = $stmt->get_result()->fetch_assoc()['price'];
        $total += $price * $qty;
    }

    // lưu order
    $stmt = $conn->prepare("INSERT INTO orders (fullname,email,phone,address,total) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssssd", $fullname, $email, $phone, $address, $total);
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;

        // lưu order_items
        foreach ($_SESSION['cart'] as $pid => $qty) {
            $pr = $conn->prepare("SELECT price FROM products WHERE id=?");
            $pr->bind_param("i",$pid);
            $pr->execute();
            $price = $pr->get_result()->fetch_assoc()['price'];
            $ins = $conn->prepare("INSERT INTO order_items (order_id,product_id,qty,price) VALUES (?,?,?,?)");
            $ins->bind_param("iiid",$order_id,$pid,$qty,$price);
            $ins->execute();
        }

        // lưu session để hiển thị lịch sử
        $_SESSION['last_order_email'] = $email;
        $_SESSION['last_order_id']    = $order_id;

        // xóa giỏ
        unset($_SESSION['cart']);

        // chuyển hướng về cart + thông báo
        header("Location: cart.php?msg=order_complete");
        exit;
    } else {
        $error = "Lỗi khi lưu đơn hàng. Vui lòng thử lại.";
    }
}

include 'header.php';
?>
<h1 class="page-title">Thanh toán</h1>
<?php if (isset($error)) echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; ?>
<form method="post" class="checkout-form">
  <label>Họ tên</label>
  <input type="text" name="fullname" required>
  <label>Email</label>
  <input type="email" name="email" required>
  <label>Số điện thoại</label>
  <input type="text" name="phone" required>
  <label>Địa chỉ</label>
  <textarea name="address" required></textarea>
  <button class="btn" type="submit">Đặt hàng</button>
</form>

<?php include 'footer.php'; ?>
