<?php
// cấu hình kết nối DB & thiết lập chung
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'usbw'); 
define('DB_NAME', 'shop_jewelry');

define('UPLOAD_DIR', __DIR__ . '/assets/images/'); 
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2MB
$allowed_ext = ['jpg','jpeg','png','gif'];
