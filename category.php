<?php
require 'init.php';
include 'header.php';

// Nếu hàm e() không tồn tại trong init.php thì định nghĩa fallback
if (!function_exists('e')) {
    function e($v) {
        return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// Lấy tên danh mục từ query string
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
if ($category === '') {
    echo "<p>Danh mục không hợp lệ.</p>";
    include 'footer.php';
    exit;
}

function to_slug($text) {
    // chuyển UTF-8 sang ASCII tương đối (loại bỏ dấu)
    $text = trim($text);
    $text = mb_strtolower($text, 'UTF-8');
    // chuyển dấu bằng iconv nếu có
    $trans = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    if ($trans !== false) {
        $text = $trans;
    }
    // thay tất cả ký tự không phải chữ/số thành '-'
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    $text = trim($text, '-');
    return $text;
}

// Map danh mục -> file banner (theo file bạn cung cấp)
$banner_map = [
    'qua-tang'      => 'banner5.png',       
    'bong-tai'      => 'bongtai.png',       
    'day-chuyen'    => 'daychuyen.png',     
    'khuyen-xo'     => 'khuyenxo.png',      
    'khuye n xo'    => 'khuyenxo.png',      
    'khuyenxo'      => 'khuyenxo.png',
    'nhan'          => 'nhan.png',          
    'trang-suc-bo'  => 'trangsucbo.png',    
    'trang-suc-doi' => 'trangsucdoi.png',   
    'vong-lac'      => 'vonglac.png',       
    'phong-thuy'    => 'phongthuy.png',    

    'trangsucbo'    => 'trangsucbo.png',
    'trangsucdoi'   => 'trangsucdoi.png',
    'vonglac'       => 'vonglac.png',
    'phongthuy'     => 'phongthuy.png',
    'quat tang'     => 'banner5.png',       // fallback alias
];

// Tạo khóa để so khớp
$slug = to_slug($category);

// nếu slug tồn tại trong map dùng file tương ứng, nếu không tìm thấy dùng banner mặc định banner.png
$bannerFile = 'banner.png'; // tên file mặc định (theo bạn banner mới là banner.png)
if (isset($banner_map[$slug]) && !empty($banner_map[$slug])) {
    $bannerFile = $banner_map[$slug];
} else {
    // thử kiểm tra một vài biến thể (bỏ dấu, bỏ dấu cách vs gạch ngang)
    $altKey = str_replace('-', '', $slug);
    if (isset($banner_map[$altKey])) $bannerFile = $banner_map[$altKey];
}

// Build path và kiểm tra tồn tại file trong assets/images/
$bannerPath = "assets/images/{$bannerFile}";
if (!file_exists($bannerPath)) {
    // nếu file đã map không tồn tại, dùng banner.png mặc định (nếu có) hoặc không hiển thị
    $fallback = "assets/images/banner.png";
    if (file_exists($fallback)) {
        $bannerPath = $fallback;
    } else {
        // nếu không có cả fallback, đặt rỗng (không hiện ảnh)
        $bannerPath = '';
    }
}

// Lấy sản phẩm theo danh mục
$stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
if ($stmt === false) {
    // lỗi prepare, hiển thị thông báo debug nhẹ (bạn có thể bỏ khi chạy production)
    echo "<p>Lỗi truy vấn (prepare): " . e($conn->error) . "</p>";
    include 'footer.php';
    exit;
}
$stmt->bind_param("s", $category);
$stmt->execute();
$res = $stmt->get_result();

// Lấy tất cả sản phẩm (mảng)
$products = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<!-- Banner danh mục -->
<?php if ($bannerPath !== ''): ?>
    <div class="site-banner category-banner" style="margin-top:12px;">
        <img src="<?php echo e($bannerPath); ?>" alt="<?php echo e($category); ?> banner" loading="lazy">
    </div>
<?php endif; ?>

<!-- Tiêu đề danh mục -->
<h1 class="section-title" style="margin-top:18px">
    <span><?php echo e(mb_strtoupper($category, 'UTF-8')); ?></span>
</h1>

<?php if (count($products) > 0): ?>
    <div class="product-grid">
        <?php foreach ($products as $p): 
            // dùng e() để escape trước khi in
            $img = !empty($p['image']) ? $p['image'] : 'no-image.png';
            $imgPath = "assets/images/" . $img;
            if (!file_exists($imgPath)) $imgPath = "assets/images/no-image.png"; // fallback
        ?>
            <div class="card">
                <a href="product.php?id=<?php echo e($p['id']); ?>">
                    <img src="<?php echo e($imgPath); ?>" alt="<?php echo e($p['name']); ?>">
                </a>
                <div class="card-body">
                    <!-- gắn class product-title để JS tự điều chỉnh font nếu cần -->
                    <h3 class="product-title"><?php echo e($p['name']); ?></h3>
                    <p class="price"><?php echo number_format($p['price'], 0, ',', '.'); ?> ₫</p>
                    <div class="card-actions">
                        <a class="btn detail-btn" href="product.php?id=<?php echo e($p['id']); ?>">Chi tiết</a>
                        <a class="btn btn-secondary add-to-cart" href="cart.php?action=add&id=<?php echo e($p['id']); ?>">Thêm vào giỏ</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-category" style="margin-top:18px;">
        <p class="no-products">Mặt hàng này hiện chưa có !</p>
        <p style="margin-top:8px;">Bạn có thể xem <a href="index.php">tất cả sản phẩm</a> hoặc kiểm tra danh mục khác.</p>
    </div>
<?php endif; ?>

<?php
include 'footer.php';
