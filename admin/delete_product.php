<?php
session_start();

// kiểm tra admin
if (!isset($_SESSION['admin_user'])) {
    header('Location: login.php');
    exit;
}

// require DB + init (điều chỉnh đường dẫn nếu project của bạn khác)
require_once __DIR__ . '/../init.php';
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header('Location: products.php');
    exit;
}

$id = intval($_POST['id']);

// lấy tên ảnh (nếu có) để xóa file
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row && !empty($row['image'])) {
    $imgPath = __DIR__ . '/../assets/images/' . $row['image'];
    if (file_exists($imgPath)) {
        @unlink($imgPath); // im lặng nếu xóa lỗi
    }
}

// xóa record
$del = $conn->prepare("DELETE FROM products WHERE id = ?");
$del->bind_param("i", $id);
$del->execute();

// (tuỳ chọn) thông báo trạng thái
header('Location: products.php?msg=deleted');
exit;
