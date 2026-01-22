# Hướng dẫn tự sửa hình ảnh sản phẩm

## Cách 1: Sửa qua Admin Panel (Dễ nhất - Khuyến nghị)

### Bước 1: Truy cập Admin Panel
1. Mở trình duyệt và vào địa chỉ: `http://127.0.0.1:8000/admin`
2. Đăng nhập bằng tài khoản admin của bạn

### Bước 2: Tìm và sửa sản phẩm
1. Trong menu bên trái, click vào **"Sản phẩm"**
2. Tìm sản phẩm cần sửa (ví dụ: "Nước ép cam tươi")
3. Click vào nút **"Sửa"** (biểu tượng bút chì) ở cột hành động

### Bước 3: Thay đổi hình ảnh
1. Trong form sửa sản phẩm, tìm trường **"Hình ảnh đại diện"** hoặc **"Featured Image"**
2. Click vào nút **"Chọn tệp"** hoặc **"Upload"**
3. Chọn hình ảnh mới từ máy tính của bạn
4. Click **"Lưu"** để lưu thay đổi

### Lưu ý:
- Hình ảnh sẽ được tự động lưu vào thư mục `public/images/products/`
- Tên file sẽ được tự động tạo, bạn không cần lo về tên file
- Hệ thống sẽ tự động resize và tối ưu hình ảnh

---

## Cách 2: Sửa trực tiếp trong thư mục (Nâng cao)

### Bước 1: Chuẩn bị hình ảnh
1. Chuẩn bị hình ảnh mới với tên phù hợp:
   - Nước ép cam tươi → `orange-juice.jpg`
   - Nước ép dưa hấu → `watermelon-juice.jpg`
   - Sinh tố bơ → `avocado-smoothie.jpg`
   - Nước ép cà rốt → `carrot-juice.jpg`
   - Sinh tố xoài → `mango-smoothie.jpg`

### Bước 2: Copy hình ảnh vào thư mục
1. Copy file hình ảnh vào thư mục: `public/images/products/`
2. Đảm bảo tên file đúng với tên trong database

### Bước 3: Cập nhật database (Qua Admin Panel)
1. Vào Admin Panel → Sản phẩm
2. Sửa sản phẩm cần thay đổi
3. Trong trường "Hình ảnh đại diện", nhập đường dẫn: `products/tên-file.jpg`
4. Click "Lưu"

---

## Cách 3: Sửa trực tiếp trong Database (Chỉ dành cho người có kinh nghiệm)

### Bước 1: Mở phpMyAdmin
1. Truy cập: `http://localhost/phpmyadmin`
2. Chọn database: `quanlybanhang`
3. Chọn bảng: `products`

### Bước 2: Tìm sản phẩm
1. Tìm sản phẩm cần sửa (ví dụ: ID = 9 cho "Nước ép cam tươi")
2. Click "Sửa" (Edit)

### Bước 3: Cập nhật đường dẫn hình ảnh
1. Tìm cột `featured_image`
2. Thay đổi giá trị thành: `products/tên-file-mới.jpg`
3. Click "Thực thi" (Go) để lưu

---

## Lưu ý quan trọng:

1. **Định dạng file**: Chỉ chấp nhận: `.jpg`, `.jpeg`, `.png`, `.webp`
2. **Kích thước**: Nên resize hình ảnh về khoảng 800x800px để tối ưu
3. **Tên file**: Nên dùng tên không dấu, không khoảng trắng (ví dụ: `orange-juice.jpg`)
4. **Đường dẫn**: Luôn bắt đầu bằng `products/` (ví dụ: `products/orange-juice.jpg`)

---

## Xem lại sau khi sửa:

1. Làm mới trang web (F5 hoặc Ctrl+F5)
2. Vào trang danh mục "Đồ uống": `http://127.0.0.1:8000/danh-muc?id=3`
3. Kiểm tra xem hình ảnh đã đúng chưa

---

## Cần hỗ trợ?

Nếu gặp vấn đề, hãy kiểm tra:
- File hình ảnh có tồn tại trong `public/images/products/` không?
- Đường dẫn trong database có đúng không?
- Đã clear cache trình duyệt chưa? (Ctrl+F5)
