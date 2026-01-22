# PHÂN TÍCH THIẾT KẾ HỆ THỐNG WEBSITE MUA BÁN ĐIỆN THOẠI DI ĐỘNG

## 1. TỔNG QUAN DỰ ÁN

### 1.1. Giới thiệu
Hệ thống website thương mại điện tử chuyên về mua bán điện thoại di động, cung cấp nền tảng trực tuyến cho việc tìm kiếm, so sánh và mua sắm điện thoại. Hệ thống sử dụng thanh toán chuyển khoản ngân hàng qua mã QR, không tích hợp cổng thanh toán tự động.

### 1.2. Mục tiêu hệ thống
- Cung cấp nền tảng mua bán điện thoại trực tuyến dễ sử dụng
- Hỗ trợ khách hàng tìm kiếm và so sánh sản phẩm hiệu quả
- Quản lý đơn hàng và xác nhận thanh toán thủ công qua ảnh chuyển khoản
- Tối ưu trải nghiệm người dùng trên mọi thiết bị
- Dễ dàng quản trị và bảo trì

### 1.3. Phạm vi hệ thống
**Bao gồm:**
- Quản lý sản phẩm (điện thoại, phụ kiện)
- Quản lý danh mục và thương hiệu
- Giỏ hàng và đặt hàng
- Hiển thị mã QR ngân hàng cho thanh toán
- Upload và xác minh ảnh chuyển khoản
- Quản lý đơn hàng
- Đánh giá và nhận xét sản phẩm
- Quản lý nội dung và khuyến mãi

**Không bao gồm:**
- Tích hợp cổng thanh toán trực tuyến (VNPay, MoMo...)
- Quản lý kho hàng chi tiết
- Hệ thống nhập/xuất kho
- Quản lý nhà cung cấp

### 1.4. Công nghệ sử dụng

#### Backend
- **Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL 8.0+
- **ORM**: Eloquent
- **Authentication**: Laravel Sanctum/Breeze

#### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js, Vanilla JS
- **Icons**: Heroicons/Lucide

#### Storage & Media
- **File Storage**: Local Storage / AWS S3
- **Image Processing**: Intervention Image
- **QR Code**: SimpleSoftwareIO/simple-qrcode

#### Công cụ khác
- **Version Control**: Git
- **Package Manager**: Composer (PHP), NPM (JS)
- **Mail**: SMTP (Gmail, Mailgun)

## 2. KIẾN TRÚC HỆ THỐNG

### 2.1. Kiến trúc tổng thể (High-Level Architecture)

```
┌────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐ │
│  │   Web        │  │   Mobile     │  │   Tablet         │ │
│  │   Browser    │  │   Browser    │  │   Browser        │ │
│  └──────────────┘  └──────────────┘  └──────────────────┘ │
└────────────────────────────────────────────────────────────┘
                            │
                            ↓ HTTPS
┌────────────────────────────────────────────────────────────┐
│                    WEB SERVER (Nginx/Apache)                │
└────────────────────────────────────────────────────────────┘
                            │
                            ↓
┌────────────────────────────────────────────────────────────┐
│                   APPLICATION LAYER (Laravel)               │
│  ┌──────────────────────────────────────────────────────┐ │
│  │                    Routes & Middleware                │ │
│  └──────────────────────────────────────────────────────┘ │
│  ┌──────────────────────────────────────────────────────┐ │
│  │                     Controllers                       │ │
│  │  • ProductController  • OrderController               │ │
│  │  • CartController     • PaymentController             │ │
│  │  • UserController     • ReviewController              │ │
│  └──────────────────────────────────────────────────────┘ │
│  ┌──────────────────────────────────────────────────────┐ │
│  │                   Business Logic                      │ │
│  │  • Services       • Repositories                      │ │
│  └──────────────────────────────────────────────────────┘ │
│  ┌──────────────────────────────────────────────────────┐ │
│  │                   Models (Eloquent)                   │ │
│  └──────────────────────────────────────────────────────┘ │
└────────────────────────────────────────────────────────────┘
                            │
                            ↓
┌────────────────────────────────────────────────────────────┐
│                     DATA LAYER (MySQL)                      │
│  • Products    • Orders      • Users                        │
│  • Categories  • Payments    • Reviews                      │
└────────────────────────────────────────────────────────────┘
                            │
                    ┌───────┴───────┐
                    ↓               ↓
        ┌────────────────┐  ┌────────────────┐
        │ File Storage   │  │  Cache Layer   │
        │ (Images, QR)   │  │  (Redis)       │
        └────────────────┘  └────────────────┘
```

### 2.2. Kiến trúc phân lớp (Layered Architecture)

#### 2.2.1. Presentation Layer (Lớp giao diện)
**Chức năng:**
- Hiển thị giao diện người dùng
- Xử lý input từ người dùng
- Render HTML, CSS, JavaScript

**Thành phần:**
- Blade Templates
- Views (Admin/Customer)
- Components (Header, Footer, Product Card...)
- Assets (CSS, JS, Images)

**Trách nhiệm:**
- Không chứa business logic
- Chỉ hiển thị dữ liệu từ Controller
- Validation cơ bản phía client

#### 2.2.2. Application Layer (Lớp ứng dụng)
**Chức năng:**
- Điều phối luồng xử lý
- Xử lý HTTP Request/Response
- Validation dữ liệu

**Thành phần:**
- Controllers
- Middleware (Authentication, Authorization)
- Form Requests
- Resources (API Response)

**Trách nhiệm:**
- Nhận request từ user
- Gọi Service/Repository xử lý
- Trả về View hoặc JSON

#### 2.2.3. Business Logic Layer (Lớp nghiệp vụ)
**Chức năng:**
- Chứa logic nghiệp vụ chính
- Xử lý các quy tắc kinh doanh
- Tính toán, xử lý dữ liệu phức tạp

**Thành phần:**
- Services (ProductService, OrderService, CartService...)
- Business Rules
- Helper Classes

**Trách nhiệm:**
- Tính toán giá trị đơn hàng
- Xử lý logic giỏ hàng
- Validate business rules
- Xử lý luồng đặt hàng

#### 2.2.4. Data Access Layer (Lớp truy cập dữ liệu)
**Chức năng:**
- Tương tác với database
- CRUD operations
- Query optimization

**Thành phần:**
- Models (Eloquent)
- Repositories
- Database Migrations
- Seeders

**Trách nhiệm:**
- Truy vấn database
- Relationships giữa các bảng
- Caching dữ liệu

#### 2.2.5. Infrastructure Layer (Lớp hạ tầng)
**Chức năng:**
- Xử lý storage
- Email, SMS
- Third-party services

**Thành phần:**
- File Storage
- Mail Service
- QR Code Generator
- Image Processing

### 2.3. Mô hình MVC trong Laravel

```
Request → Route → Middleware → Controller
                                    ↓
                            ┌──────┴──────┐
                            ↓             ↓
                        Service      Repository
                            ↓             ↓
                        Model ←──────────┘
                            ↓
                        Database
                            ↓
                        Response → View
```

**Luồng xử lý chi tiết:**
1. User gửi HTTP Request
2. Route nhận và xác định Controller
3. Middleware kiểm tra (Auth, CSRF...)
4. Controller nhận request
5. Controller gọi Service xử lý logic
6. Service gọi Repository/Model truy vấn DB
7. Model trả dữ liệu về Service
8. Service xử lý và trả về Controller
9. Controller trả View hoặc JSON
10. Response gửi về Client

## 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 3.1. Sơ đồ ERD (Entity Relationship Diagram)

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│   USERS      │1      n │   ORDERS     │1      n │ ORDER_ITEMS  │
│──────────────│◄────────│──────────────│◄────────│──────────────│
│ id (PK)      │         │ id (PK)      │         │ id (PK)      │
│ name         │         │ user_id (FK) │         │ order_id(FK) │
│ email        │         │ order_number │         │ product_id   │
│ password     │         │ total        │         │ quantity     │
│ role         │         │ status       │         │ price        │
└──────────────┘         └──────────────┘         └──────────────┘
       │                        │                         │
       │                        │1                        │n
       │                        │                         │
       │                        ↓n                        ↓1
       │                ┌──────────────┐         ┌──────────────┐
       │                │ PAYMENT_     │         │  PRODUCTS    │
       │                │ PROOFS       │         │──────────────│
       │                │──────────────│         │ id (PK)      │
       │                │ id (PK)      │         │ category_id  │
       │                │ order_id(FK) │         │ brand_id     │
       │                │ image_path   │         │ name         │
       │                │ status       │         │ price        │
       │                │ verified_by  │         │ quantity     │
       │                └──────────────┘         └──────────────┘
       │                                                  │
       │1                                                 │n
       │                                                  ↓1
       ↓n                                        ┌──────────────┐
┌──────────────┐         ┌──────────────┐       │ CATEGORIES   │
│   REVIEWS    │         │   BRANDS     │       │──────────────│
│──────────────│         │──────────────│       │ id (PK)      │
│ id (PK)      │         │ id (PK)      │       │ name         │
│ user_id (FK) │         │ name         │       │ parent_id    │
│ product_id   │         │ logo         │       │ slug         │
│ rating       │         │ status       │       └──────────────┘
│ comment      │         └──────────────┘
└──────────────┘                 ↑1
                                 │n
                                 │
                         ┌──────────────┐
                         │  PRODUCTS    │
                         └──────────────┘

                    ┌──────────────┐
                    │ BANK_        │
                    │ ACCOUNTS     │
                    │──────────────│
                    │ id (PK)      │
                    │ bank_name    │
                    │ account_no   │
                    │ qr_code_path │
                    │ is_default   │
                    └──────────────┘
```

### 3.2. Danh sách các bảng và mối quan hệ

#### Bảng chính:

**1. users** (Người dùng)
- Lưu thông tin khách hàng và admin
- Relationship: 1-n với orders, reviews
- Index: email, role

**2. categories** (Danh mục)
- Cấu trúc phân cấp (parent-child)
- Relationship: 1-n với products, self-reference
- Index: slug, parent_id

**3. brands** (Thương hiệu)
- Thông tin nhà sản xuất
- Relationship: 1-n với products
- Index: slug

**4. products** (Sản phẩm)
- Thông tin chi tiết điện thoại
- Relationship: n-1 với categories, brands; 1-n với order_items, reviews, product_images
- Index: category_id, brand_id, slug, price, status

**5. product_images** (Hình ảnh sản phẩm)
- Lưu nhiều ảnh cho 1 sản phẩm
- Relationship: n-1 với products
- Index: product_id

**6. orders** (Đơn hàng)
- Thông tin đơn hàng tổng thể
- Relationship: n-1 với users; 1-n với order_items, payment_proofs
- Index: user_id, order_number, order_status, payment_status

**7. order_items** (Chi tiết đơn hàng)
- Sản phẩm trong đơn hàng
- Relationship: n-1 với orders, products
- Index: order_id, product_id

**8. payment_proofs** (Chứng từ thanh toán)
- Ảnh chuyển khoản từ khách hàng
- Relationship: n-1 với orders
- Index: order_id, status

**9. bank_accounts** (Tài khoản ngân hàng)
- Thông tin TK nhận tiền + QR code
- Relationship: Không có FK
- Index: is_default

**10. reviews** (Đánh giá)
- Nhận xét của khách về sản phẩm
- Relationship: n-1 với users, products
- Index: product_id, user_id, status

**11. coupons** (Mã giảm giá)
- Quản lý khuyến mãi
- Index: code, status

**12. banners** (Banner quảng cáo)
- Hình ảnh quảng cáo trên trang chủ
- Index: position, status

**13. posts** (Bài viết/Tin tức)
- Nội dung blog, tin tức
- Relationship: n-1 với users
- Index: slug, status

### 3.3. Thiết kế chi tiết các bảng quan trọng

#### Bảng: products
```
Các trường quan trọng:
- specifications (JSON): Lưu thông số kỹ thuật
  {
    "screen": "6.7 inch",
    "chip": "Snapdragon 8 Gen 2",
    "ram": "12GB",
    "storage": "256GB",
    "battery": "5000mAh",
    "camera": "200MP"
  }
- price vs sale_price: Giá gốc và giá khuyến mãi
- quantity: Số lượng tồn kho (đơn giản, không quản lý kho)
- status: active/inactive/out_of_stock
- is_featured, is_new: Đánh dấu sản phẩm nổi bật, mới
```

#### Bảng: orders
```
Các trạng thái đơn hàng (order_status):
- pending: Chờ xử lý (vừa tạo)
- confirmed: Đã xác nhận (admin kiểm tra)
- processing: Đang chuẩn bị hàng
- shipping: Đang giao hàng
- delivered: Đã giao thành công
- cancelled: Đã hủy

Các trạng thái thanh toán (payment_status):
- pending: Chờ thanh toán
- paid: Đã thanh toán (admin xác nhận)
- failed: Thanh toán thất bại
```

#### Bảng: payment_proofs
```
Luồng xử lý:
1. Khách đặt hàng → tạo order (payment_status = pending)
2. Hiển thị QR code ngân hàng cho khách
3. Khách chuyển khoản và upload ảnh → tạo payment_proof
4. Admin xem ảnh và xác nhận
5. Nếu OK: payment_proof.status = verified, order.payment_status = paid
6. Nếu sai: payment_proof.status = rejected
```

#### Bảng: bank_accounts
```
Lưu thông tin tài khoản ngân hàng:
- Có thể có nhiều TK
- is_default = true: TK mặc định hiển thị
- qr_code_path: Đường dẫn file QR code
- Có thể tạo QR động với số tiền và nội dung
```

### 3.4. Indexes và Optimization

**Indexes cần thiết:**
```
products:
- INDEX(category_id, brand_id)
- INDEX(price)
- INDEX(status)
- FULLTEXT(name, description) - cho search

orders:
- INDEX(user_id, order_status)
- INDEX(order_number) UNIQUE
- INDEX(payment_status)
- INDEX(created_at)

reviews:
- INDEX(product_id, status)
- INDEX(user_id)

payment_proofs:
- INDEX(order_id)
- INDEX(status)
```

**Query Optimization:**
- Sử dụng Eager Loading cho relationships
- Cache danh sách categories, brands
- Pagination cho danh sách sản phẩm
- Index cho các cột thường dùng trong WHERE, JOIN

## 4. THIẾT KẾ CHỨC NĂNG CHI TIẾT

### 4.1. Module Quản lý Sản phẩm

#### 4.1.1. Chức năng Admin
**Danh sách sản phẩm:**
- Hiển thị bảng với phân trang
- Tìm kiếm theo tên, SKU, danh mục, thương hiệu
- Lọc theo trạng thái, giá, số lượng
- Sắp xếp theo các cột
- Thao tác: Xem, Sửa, Xóa, Active/Inactive

**Thêm/Sửa sản phẩm:**
- Form nhập thông tin cơ bản: tên, slug, SKU
- Chọn danh mục, thương hiệu
- Nhập giá, giá khuyến mãi
- Nhập số lượng
- Upload ảnh chính + nhiều ảnh phụ
- Nhập mô tả ngắn và chi tiết (WYSIWYG editor)
- Nhập thông số kỹ thuật (form động)
- Đánh dấu: Nổi bật, Mới, Trạng thái
- SEO: Meta title, description, keywords

**Validation:**
- Tên sản phẩm: required, max 255
- Slug: required, unique, format
- SKU: unique nếu có
- Giá: required, numeric, min 0
- Giá KM: numeric, nhỏ hơn giá gốc
- Số lượng: integer, min 0
- Ảnh: image, max 2MB, jpg/png
- Danh mục, Thương hiệu: required, exists

#### 4.1.2. Chức năng Customer
**Danh sách sản phẩm:**
- Grid/List view
- Phân trang
- Filter sidebar:
    - Danh mục (checkbox tree)
    - Thương hiệu (checkbox)
    - Khoảng giá (range slider)
    - Đánh giá (stars)
    - Tính năng đặc biệt
- Sort: Giá, Tên, Mới nhất, Bán chạy
- Quick view modal

**Chi tiết sản phẩm:**
- Breadcrumb
- Ảnh gallery (zoom, lightbox)
- Thông tin: Tên, Giá, SKU, Tình trạng
- Mô tả ngắn
- Chọn số lượng
- Nút: Thêm giỏ hàng, Mua ngay
- Tab: Mô tả chi tiết, Thông số, Đánh giá
- Sản phẩm liên quan
- Sản phẩm đã xem

**Tìm kiếm:**
- Search bar ở header
- Autocomplete suggestions
- Search results page với filter
- Highlight từ khóa

**So sánh sản phẩm:**
- Checkbox chọn sản phẩm để so sánh (max 3-4)
- Trang so sánh hiển thị bảng:
    - Hình ảnh, Tên, Giá
    - Các thông số kỹ thuật
    - Highlight điểm khác biệt

### 4.2. Module Giỏ hàng & Đặt hàng

#### 4.2.1. Giỏ hàng
**Lưu trữ:**
- Session-based (chưa đăng nhập)
- Database (đã đăng nhập)

**Chức năng:**
- Hiển thị danh sách sản phẩm trong giỏ
- Cập nhật số lượng (AJAX)
- Xóa sản phẩm
- Tính tổng tiền tự động
- Áp dụng mã giảm giá
- Hiển thị số lượng ở header icon

**Validation:**
- Kiểm tra số lượng tồn kho
- Số lượng min = 1
- Nếu hết hàng → thông báo

#### 4.2.2. Quy trình đặt hàng

**Bước 1: Giỏ hàng**
- Xem lại sản phẩm
- Cập nhật số lượng
- Nhấn "Thanh toán"

**Bước 2: Thông tin giao hàng**
- Form nhập:
    - Họ tên (required)
    - Email (required, email format)
    - Số điện thoại (required, phone format)
    - Địa chỉ chi tiết (required)
    - Tỉnh/Thành phố (select)
    - Quận/Huyện (select)
    - Phường/Xã (select)
    - Ghi chú (optional)
- Nếu đã đăng nhập: tự động điền từ profile

**Bước 3: Xác nhận & Thanh toán**
- Hiển thị tóm tắt:
    - Danh sách sản phẩm
    - Thông tin giao hàng
    - Tổng tiền
- Chọn phương thức:
    - Chuyển khoản ngân hàng
    - COD (nếu có)
- Nút "Đặt hàng"

**Bước 4: Hiển thị thông tin thanh toán**
- Tạo order thành công
- Hiển thị:
    - Mã đơn hàng
    - Tổng tiền cần thanh toán
    - Thông tin ngân hàng nhận tiền
    - Mã QR thanh toán
    - Nội dung chuyển khoản: "DH{order_number}"
- Form upload ảnh chuyển khoản
- Hướng dẫn thanh toán
- Lưu ý quan trọng

**Bước 5: Upload chứng từ**
- Khách chuyển khoản theo QR
- Upload ảnh bill/screenshot
- Nhập mã giao dịch (optional)
- Nhập số tiền đã chuyển
- Gửi xác nhận

**Xử lý backend:**
```
1. Validate thông tin đơn hàng
2. Kiểm tra tồn kho các sản phẩm
3. Tạo Order:
   - Tạo order_number unique
   - Lưu thông tin khách hàng
   - order_status = pending
   - payment_status = pending
4. Tạo Order_Items từ cart
5. Giảm quantity của products
6. Xóa cart
7. Gửi email xác nhận đơn hàng
8. Redirect đến trang thanh toán
```

### 4.3. Module Quản lý Đơn hàng

#### 4.3.1. Admin - Quản lý đơn hàng

**Danh sách đơn hàng:**
- Bảng hiển thị:
    - Mã đơn, Ngày đặt
    - Khách hàng
    - Tổng tiền
    - Trạng thái đơn
    - Trạng thái thanh toán
    - Thao tác
- Filter:
    - Trạng thái đơn
    - Trạng thái thanh toán
    - Khoảng ngày
    - Tìm theo mã, tên KH, SĐT
- Export Excel

**Chi tiết đơn hàng:**
- Thông tin đơn hàng
- Thông tin khách hàng
- Danh sách sản phẩm
- Lịch sử trạng thái
- Thông tin thanh toán
- Chứng từ thanh toán (nếu có)
- Actions:
    - Cập nhật trạng thái
    - Xác nhận thanh toán
    - Hủy đơn
    - In đơn hàng

**Xác nhận thanh toán:**
- Admin vào chi tiết đơn
- Xem ảnh chuyển khoản khách upload
- Kiểm tra:
    - Số tiền có khớp không
    - Thời gian chuyển khoản
    - Nội dung chuyển khoản
- Nếu đúng:
    - Đánh dấu payment_proof.status = verified
    - Cập nhật order.payment_status = paid
    - Gửi email thông báo cho khách
- Nếu sai:
    - Đánh dấu payment_proof.status = rejected
    - Gửi email yêu cầu chuyển lại

**Workflow trạng thái:**
```
pending → confirmed → processing → shipping → delivered
   ↓
cancelled

Quyền cập nhật:
- Admin có thể cập nhật mọi trạng thái
- Khách chỉ có thể cancel khi status = pending
```

#### 4.3.2. Customer - Theo dõi đơn hàng

**Danh sách đơn hàng:**
- Tab filter theo trạng thái
- Hiển thị card mỗi đơn:
    - Mã đơn, Ngày đặt
    - Sản phẩm (ảnh + tên)
    - Tổng tiền
    - Trạng thái
    - Button: Xem chi tiết, Upload ảnh TT

**Chi tiết đơn hàng:**
- Timeline trạng thái đơn
- Thông tin giao hàng
- Danh sách sản phẩm
- Thông tin thanh toán
- Lịch sử cập nhật
- Actions:
    - Hủy đơn (nếu pending)
    - Upload ảnh thanh toán
    - Đánh giá (nếu delivered)
    - Liên hệ hỗ trợ

**Thông báo:**
- Email mỗi khi trạng thái thay đổi
- Thông báo trên website (nếu có)

### 4.4. Module Thanh toán QR Banking

#### 4.4.1. Quản lý Tài khoản Ngân hàng (Admin)

**Danh sách TK:**
- Hiển thị các TK đã thêm
- Thông tin: Ngân hàng, STK, Chủ TK
- Trạng thái: Active/Inactive
- Đánh dấu mặc định

**Thêm/Sửa TK:**
- Nhập thông tin:
    - Tên ngân hàng
    - Số tài khoản
    - Chủ tài khoản
    - Chi nhánh
- Upload QR code tĩnh hoặc
- Tạo QR động từ thông tin

**Tạo QR Code:**
- Sử dụng thư viện QR code generator
- QR tĩnh: Chỉ chứa STK, không có số tiền
- QR động: Tạo khi đơn hàng, chứa:
    - Số tài khoản
    - Số tiền cần thanh toán
    - Nội dung: Mã đơn hàng
    - Tên người nhận
- Format: VietQR standard

#### 4.4.2. Hiển thị thông tin thanh toán

**Sau khi đặt hàng thành công:**
```
┌─────────────────────────────────────────────┐
│   ĐẶT HÀNG THÀNH CÔNG                       │
│                                             │
│   Mã đơn hàng: #DH2024001234               │
│   Tổng tiền: 15.990.000 VNĐ                │
│                                             │
│   ═══════════════════════════════════      │
│                                             │
│   THÔNG TIN THANH TOÁN                     │
│                                             │
│   Ngân hàng: Vietcombank                   │
│   Số tài khoản: 1234567890                 │
│   Chủ tài khoản: NGUYEN VAN A              │
│   Chi nhánh: TP.HCM                        │
│                                             │
│   Số tiền: 15.990.000 VNĐ                  │
│   Nội dung CK: DH2024001234                │
│                                             │
│   [    QR CODE IMAGE    ]                  │
│   Quét mã để thanh toán                    │
│                                             │
│   ═══════════════════════════════════      │
│                                             │
│   UPLOAD CHỨNG TỪ THANH TOÁN               │
│                                             │
│   [Chọn file ảnh]  [Upload]                │
│                                             │
│   Mã giao dịch: [_____________]            │
│   Số tiền đã CK: [_____________]           │
│   Ghi chú: [____________________]          │
│                                             │
│   [Xác nhận thanh toán]                    │
│                                             │
└─────────────────────────────────────────────┘
```

**Lưu ý cho khách hàng:**
- Vui lòng chuyển khoản đúng số tiền và nội dung
- Sau khi chuyển khoản, upload ảnh chứng từ
- Đơn hàng sẽ được xử lý sau khi xác nhận thanh toán
- Thời gian xác nhận: 1-24 giờ

#### 4.4.3. Upload và xác minh chứng từ

**Upload ảnh (Customer):**
- Chọn file từ thiết bị
- Preview trước khi upload
- Validation:
    - Format: JPG, PNG
    - Size: Max 5MB
    - Required
- Nhập thông tin bổ sung:
    - Mã giao dịch (nếu có)
    - Số tiền đã chuyển
    - Ghi chú
- Submit → Tạo payment_proof record

**Xác minh (Admin):**
- Vào chi tiết đơn hàng
- Tab "Chứng từ thanh toán"
- Hiển thị:
    - Ảnh chuyển khoản (zoom được)
    - Thông tin KH nhập
    - Thông tin đơn hàng
    - Thời gian upload
- Actions:
    - [Xác nhận] → verified
    - [Từ chối] → rejected + lý do
- Khi xác nhận:
    - Update order.payment_status = paid
    - Gửi email thông báo
    - Tự động chuyển order_status = confirmed

**Trường hợp đặc biệt:**
- Khách chuyển thiếu: Thông báo bổ sung
- Khách chuyển thừa: Ghi nhận + hoàn lại hoặc giữ credit
- Không khớp nội dung: Liên hệ xác nhận
- Chuyển nhầm TK: Từ chối + hướng dẫn

### 4.5. Module Đánh giá & Nhận xét

#### 4.5.1. Viết đánh giá (Customer)

**Điều kiện:**
- Đã mua sản phẩm (exists order_item)
- Đơn hàng có trạng thái delivered
- Chưa đánh giá sản phẩm này

**Form đánh giá:**
- Chọn số sao (1-5)
- Tiêu đề (optional)
- Nội dung đánh giá
- Upload ảnh/video (optional, max 5 files)
- Submit

**Xử lý:**
- Lưu review với status = pending
- Admin duyệt trước khi hiển thị
- Tính lại rating trung bình của product

#### 4.5.2. Quản lý đánh giá (Admin)

**Danh sách review:**
- Filter theo: Sản phẩm, Trạng thái, Rating
- Hiển thị: Khách hàng, Sản phẩm, Rating, Nội dung
- Actions: Duyệt, Từ chối, Xóa

**Chi tiết review:**
- Thông tin đầy đủ
- Lịch sử đơn hàng của KH
- Quyết định: Approve/Reject

**Hiển thị trên trang sản phẩm:**
- Tổng quan:
    - Rating trung bình (stars + số)
    - Phân bố rating (bar chart)
    - Tổng số đánh giá
- Filter: Tất cả, 5 sao, 4 sao...
- Sort: Mới nhất, Hữu ích nhất
- Mỗi review hiển thị:
    - Avatar, Tên KH
    - Rating stars
    - Tiêu đề
    - Nội dung
    - Ảnh đính kèm
    - Ngày đăng
    - Đã mua hàng (verified)
    - Nút: Hữu ích, Báo cáo

### 4.6. Module Khuyến mãi

#### 4.6.1. Mã giảm giá (Coupon)

**Tạo mã giảm giá:**
- Thông tin:
    - Mã code (unique)
    - Mô tả
    - Loại: Giảm % hoặc giảm số tiền cố định
    - Giá trị giảm
    - Giá trị đơn tối thiểu
    - Giảm tối đa (nếu %)
    - Số lượt dùng (total)
    - Thời gian hiệu lực
    - Trạng thái

**Áp dụng mã:**
- Khách nhập mã ở trang giỏ hàng
- Validate:
    - Mã có tồn tại không
    - Còn hiệu lực không
    - Đạt giá trị tối thiểu không
    - Còn lượt dùng không
- Nếu hợp lệ:
    - Tính số tiền giảm
    - Hiển thị tổng mới
    - Lưu coupon_id vào order

**Tracking:**
- Số lần đã dùng
- Danh sách đơn hàng sử dụng
- Hiệu quả của mã

#### 4.6.2. Flash Sale / Khuyến mãi theo thời gian

**Thiết lập:**
- Chọn sản phẩm
- Giá khuyến mãi
- Thời gian bắt đầu - kết thúc
- Số lượng giới hạn (nếu có)

**Hiển thị:**
- Badge "Sale X%"
- Countdown timer
- Progress bar số lượng còn lại

**Xử lý:**
- Cronjob check và cập nhật trạng thái
- Tự động áp dụng giá sale trong thời gian
- Tự động kết thúc khi hết hạn hoặc hết số lượng

### 4.7. Module Quản lý Nội dung

#### 4.7.1. Banner

**Quản lý banner:**
- Upload ảnh banner
- Thiết lập:
    - Tiêu đề
    - Link đích
    - Vị trí: Home slider, Home banner, Sidebar
    - Thứ tự hiển thị
    - Thời gian hiển thị
    - Trạng thái
- Có thể có nhiều banner/vị trí
- Rotation tự động

**Hiển thị:**
- Home slider: Slider/Carousel
- Banner: Fixed position
- Responsive

#### 4.7.2. Bài viết / Tin tức

**Quản lý bài viết:**
- Editor WYSIWYG
- Thông tin:
    - Tiêu đề
    - Slug
    - Tóm tắt
    - Nội dung đầy đủ
    - Ảnh đại diện
    - Trạng thái: Draft/Published
    - Ngày xuất bản
- Category (nếu cần)

**Hiển thị:**
- Trang danh sách tin tức
- Chi tiết bài viết
- Bài liên quan
- Share social

#### 4.7.3. Trang tĩnh

**Các trang cần có:**
- Giới thiệu
- Chính sách bảo hành
- Chính sách đổi trả
- Chính sách vận chuyển
- Điều khoản sử dụng
- Liên hệ

**CMS đơn giản:**
- Title, Content (HTML)
- SEO meta
- Có thể sử dụng Page builder

## 5. THIẾT KẾ GIAO DIỆN NGƯỜI DÙNG (UI/UX)

### 5.1. Layout chung

#### 5.1.1. Frontend (Customer)

**Header:**
```
┌─────────────────────────────────────────────────────────┐
│  [Logo]    [Menu]   [Tìm kiếm...]  [Giỏ] [User] [Lang] │
│                                                          │
│  Danh mục | Điện thoại | Phụ kiện | Tin tức | Liên hệ  │
└─────────────────────────────────────────────────────────┘
```

- Logo: Click về trang chủ
- Menu chính: Mega menu cho categories
- Search bar: Autocomplete
- Cart icon: Số lượng sản phẩm
- User menu: Login/Register hoặc Profile dropdown
- Sticky header khi scroll

**Footer:**
```
┌─────────────────────────────────────────────────────────┐
│  [Về chúng tôi]  [Chính sách]  [Hỗ trợ]  [Liên hệ]     │
│                                                          │
│  Thông tin công ty                                      │
│  Địa chỉ, SĐT, Email                                    │
│  Social media links                                      │
│  Payment methods                                         │
│                                                          │
│  Copyright © 2024                                        │
└─────────────────────────────────────────────────────────┘
```

**Sidebar (Product page):**
- Filter options
- Danh mục
- Thương hiệu
- Khoảng giá
- Tính năng

#### 5.1.2. Backend (Admin)

**Sidebar Menu:**
```
┌──────────────────┐
│  [Logo Admin]    │
├──────────────────┤
│ Dashboard        │
│ Sản phẩm         │
│  - Danh sách     │
│  - Thêm mới      │
│  - Danh mục      │
│  - Thương hiệu   │
│ Đơn hàng         │
│ Thanh toán       │
│  - Xác nhận      │
│  - Tài khoản NH  │
│ Khách hàng       │
│ Đánh giá         │
│ Khuyến mãi       │
│ Nội dung         │
│  - Banner        │
│  - Bài viết      │
│  - Trang         │
│ Cài đặt          │
│ [Logout]         │
└──────────────────┘
```

**Main Content:**
- Breadcrumb
- Page title + Actions
- Content area
- Responsive

### 5.2. Các màn hình chính

#### 5.2.1. Trang chủ

**Sections:**
1. Hero Slider (Banner chính)
2. Danh mục nổi bật (Grid cards)
3. Sản phẩm nổi bật (Carousel)
4. Flash Sale (nếu có)
5. Sản phẩm mới nhất
6. Banner quảng cáo
7. Sản phẩm bán chạy
8. Tin tức/Blog (3-4 bài mới)
9. Đối tác/Thương hiệu

**Features:**
- Lazy loading images
- Smooth animations
- Call-to-action buttons rõ ràng

#### 5.2.2. Trang danh sách sản phẩm

**Layout:**
```
┌─────────────────────────────────────────────┐
│  [Breadcrumb]                               │
│  ┌────────┬──────────────────────────────┐ │
│  │Filter  │  [Grid/List] [Sort] [30 items]│ │
│  │Sidebar │  ┌────┬────┬────┬────┐        │ │
│  │        │  │Pro │Pro │Pro │Pro │        │ │
│  │        │  │ 1  │ 2  │ 3  │ 4  │        │ │
│  │        │  └────┴────┴────┴────┘        │ │
│  │        │  ┌────┬────┬────┬────┐        │ │
│  │        │  │Pro │Pro │Pro │Pro │        │ │
│  │        │  │ 5  │ 6  │ 7  │ 8  │        │ │
│  │        │  └────┴────┴────┴────┘        │ │
│  │        │  [Pagination]                 │ │
│  └────────┴──────────────────────────────┘ │
└─────────────────────────────────────────────┘
```

**Product Card:**
- Ảnh sản phẩm
- Tên sản phẩm
- Giá (gạch ngang nếu có sale)
- Rating + số đánh giá
- Badge: New, Hot, Sale
- Quick view icon
- Add to cart button

#### 5.2.3. Trang chi tiết sản phẩm

**Layout:**
```
┌─────────────────────────────────────────────────┐
│  [Breadcrumb]                                   │
│  ┌──────────────┬──────────────────────────┐   │
│  │              │  [Product Name]          │   │
│  │   Product    │  Rating: ★★★★☆ (24)     │   │
│  │   Images     │  SKU: ABC123             │   │
│  │   Gallery    │                          │   │
│  │              │  Price: 15.990.000đ      │   │
│  │ [Main Image] │  Old: 18.990.000đ        │   │
│  │              │                          │   │
│  │ [Thumbnail]  │  [Mô tả ngắn...]        │   │
│  │ [Thumbnail]  │                          │   │
│  │ [Thumbnail]  │  Số lượng: [-] [1] [+]  │   │
│  │ [Thumbnail]  │                          │   │
│  │              │  [Thêm giỏ hàng] [Mua]  │   │
│  └──────────────┴──────────────────────────┘   │
│                                                 │
│  [Tab: Mô tả | Thông số | Đánh giá]            │
│  [Tab Content Area]                             │
│                                                 │
│  [Sản phẩm liên quan]                           │
│  [Product Grid]                                 │
└─────────────────────────────────────────────────┘
```

**Tab Đánh giá:**
- Tổng quan rating
- Filter + Sort
- Danh sách reviews
- Form viết đánh giá (nếu đủ điều kiện)

#### 5.2.4. Trang giỏ hàng

**Layout:**
```
┌─────────────────────────────────────────────────┐
│  GIỎ HÀNG CỦA BẠN                               │
│  ┌────────────────────────────┬──────────────┐ │
│  │ [✓] [Img] Product Name     │ Price        │ │
│  │     Color: X, Size: Y      │ Quantity: [] │ │
│  │     [Xóa]                  │ Total: xxx   │ │
│  ├────────────────────────────┼──────────────┤ │
│  │ [✓] [Img] Product Name     │ Price        │ │
│  │     [Xóa]                  │ Total: xxx   │ │
│  └────────────────────────────┴──────────────┘ │
│                                                 │
│  [Mã giảm giá: _______] [Áp dụng]              │
│                                                 │
│  ┌─────────────────────────────────────────┐   │
│  │ Tạm tính:        15.990.000đ           │   │
│  │ Giảm giá:        -1.000.000đ           │   │
│  │ Phí vận chuyển:   Miễn phí             │   │
│  │ ─────────────────────────────────       │   │
│  │ Tổng cộng:       14.990.000đ           │   │
│  │                                         │   │
│  │ [Tiếp tục mua hàng]  [Thanh toán]     │   │
│  └─────────────────────────────────────────┘   │
└─────────────────────────────────────────────────┘
```

#### 5.2.5. Trang thanh toán (Checkout)

**Multi-step hoặc Single page:**

**Step 1: Thông tin giao hàng**
- Form fields
- Auto-fill nếu đã login
- Validate real-time

**Step 2: Phương thức thanh toán**
- Radio options
- Hiển thị thông tin tương ứng

**Step 3: Xác nhận**
- Review order
- Terms checkbox
- Place order button

**Sau khi đặt hàng:**
- Success message
- Order number
- Thông tin thanh toán
- QR code
- Upload form

#### 5.2.6. Trang quản lý đơn hàng (Customer)

**Layout:**
```
┌─────────────────────────────────────────────────┐
│  ĐƠN HÀNG CỦA TÔI                               │
│  [Tất cả] [Chờ TT] [Đã xác nhận] [Đang giao]   │
│                                                  │
│  ┌─────────────────────────────────────────┐    │
│  │ Đơn #DH2024001234    01/01/2024        │    │
│  │ [Img] Product Name x 1                 │    │
│  │ [Img] Product Name x 2                 │    │
│  │ ────────────────────────────────       │    │
│  │ Tổng tiền: 15.990.000đ                 │    │
│  │ Trạng thái: Đang giao hàng             │    │
│  │ [Chi tiết] [Upload TT] [Đánh giá]     │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  [Load more orders...]                           │
└─────────────────────────────────────────────────┘
```

### 5.3. Responsive Design

**Breakpoints:**
- Mobile: < 640px
- Tablet: 640px - 1024px
- Desktop: > 1024px

**Mobile adaptations:**
- Hamburger menu
- Stack layout
- Touch-friendly buttons (min 44x44px)
- Simplified filter (bottom sheet)
- Sticky add to cart button
- Swipeable galleries

**Performance:
