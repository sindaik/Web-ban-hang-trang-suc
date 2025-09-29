<?php
// db.php
$DB_HOST = '127.0.0.1';   // hoặc 'localhost'
$DB_USER = 'root';
$DB_PASS = 'usbw';        // <-- thử 'usbw' nếu USBWebServer của bạn dùng mật khẩu này
$DB_NAME = 'shop_jewelry'; // đổi tên DB nếu bạn dùng DB khác

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8mb4');
?>
