<?php
// init.php - include ở đầu mọi trang
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db.php';   

// helper functions
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// tạo thư mục ảnh nếu chưa có
if (!is_dir(__DIR__ . '/assets/images')) {
    mkdir(__DIR__ . '/assets/images', 0755, true);
}
