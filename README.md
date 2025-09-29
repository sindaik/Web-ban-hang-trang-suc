# Web bán hàng - LiLi (Shop Jewelry)

**Mô tả ngắn:**  
Website bán trang sức (PHP + MySQL) có trang danh sách/chi tiết sản phẩm, giỏ hàng, thanh toán, quản trị (admin) để thêm/sửa/xóa sản phẩm. Code dùng PHP thuần, MySQL (mysqli), session để lưu giỏ hàng, upload ảnh lưu trong `assets/images/`.

---

## Nội dung chính của README

1. Tính năng chính  
2. Cấu trúc thư mục (tóm tắt)  
3. Yêu cầu & môi trường chạy  
4. Cấu hình & kết nối database  
5. Cách cài đặt (cơ bản) — chạy trên USBWebServer / XAMPP / Laragon  
6. Tài khoản admin mặc định (để vào trang quản trị)  
7. Hướng dẫn sử dụng (thao tác admin, mua hàng)  
8. Một số lưu ý, lỗi thường gặp và gợi ý nâng cấp

---

## 1. Tính năng chính
- Hiển thị danh sách sản phẩm theo danh mục, trang chi tiết sản phẩm.  
- Thêm vào giỏ (session), cập nhật/xóa giỏ hàng.  
- Thanh toán (checkout) — lưu `orders` và `order_items` vào database.  
- Admin panel: thêm / sửa / xóa sản phẩm, cập nhật giá & giảm giá, upload ảnh sản phẩm. Thao tác xóa sẽ xóa file ảnh tương ứng trong `assets/images/`.  
- CSS chính ở `assets/css/style.css` (biến màu, layout, card sản phẩm, responsive…).

---

## 2. Cấu trúc thư mục (tóm tắt)
```
/ (project root)
  ├─ index.php               # trang chủ
  ├─ product.php             # chi tiết sản phẩm
  ├─ category.php            # danh sách theo danh mục
  ├─ cart.php                # giỏ hàng
  ├─ checkout.php            # thanh toán
  ├─ login.php / logout.php
  ├─ init.php                # include chung, session, helper
  ├─ db.php                  # cấu hình kết nối DB
  ├─ shop_jewelry.sql        # file SQL để import DB (nếu có)
  ├─ admin/                  # trang quản trị (products.php, add_product.php, edit_product.php, delete_product.php, login.php, logout.php,...)
  ├─ assets/
  │    ├─ css/style.css
  │    ├─ js/main.js, script.js
  │    └─ images/            # hình sản phẩm, banner, no-image.png, logo, ...
  └─ footer.php, header.php
```

---

## 3. Yêu cầu & môi trường
- PHP 7.x hoặc 8.x (khuyến nghị PHP 7.4+).  
- MySQL / MariaDB.  
- Web server (Apache hoặc tương tự) — USBWebServer / XAMPP / Laragon đều ok.  
- Thư mục `assets/images/` có quyền ghi để upload ảnh sản phẩm.

---

## 4. Cấu hình database (DB)
Mặc định dự án dùng cấu hình như sau:

```php
$DB_HOST = '127.0.0.1';   // hoặc 'localhost'
$DB_USER = 'root';
$DB_PASS = 'usbw';       // mặc định USBWebServer
$DB_NAME = 'shop_jewelry';
```
### Import database
1. Mở phpMyAdmin của USBWebServer.  
2. Tạo database mới tên `shop_jewelry`.  
3. Chọn tab **Import** → chọn file `shop_jewelry.sql` → nhấn **Go**.

## 5. Cách cài đặt & chạy
1. Copy toàn bộ mã nguồn vào thư mục USBWebServer (thường là `usbwebserver/root/your-project`).  
2. Import file `shop_jewelry.sql` vào phpMyAdmin như hướng dẫn trên.  
3. Chỉnh `db.php` nếu tài khoản MySQL khác.  
4. Đảm bảo thư mục `assets/images/` tồn tại và cho phép ghi.  
5. Mở trình duyệt vào:  
   - Trang chính: `http://localhost/index.php`  
   - Trang admin: `http://localhost/admin/login.php`

## 6. Tài khoản admin mặc định
- Email: `ngocdai2831@gmail.com`  
- Mật khẩu: `123456`  

## 7. Hướng dẫn sử dụng
### Admin
- Đăng nhập → Quản lý sản phẩm → Thêm/sửa/xóa sản phẩm.  
- Upload ảnh sản phẩm mới, ảnh lưu trong `assets/images/`.  

### Người dùng
- Duyệt danh mục sản phẩm → Thêm vào giỏ.  
- Vào giỏ hàng để chỉnh số lượng / xóa.  
- Thanh toán nhập thông tin → Lưu vào DB và hiển thị thông báo thành công.

---

