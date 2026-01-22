# PHÂN TÍCH THIẾT KẾ HỆ THỐNG WEBSITE BÁN ĐỒ GIA DỤNG

## 1. TỔNG QUAN DỰ ÁN

### 1.1. Giới thiệu
Hệ thống website thương mại điện tử chuyên về mua bán đồ gia dụng, cung cấp nền tảng trực tuyến cho việc tìm kiếm, so sánh và mua sắm các sản phẩm gia dụng phục vụ nhu cầu sinh hoạt hàng ngày. Hệ thống sử dụng thanh toán chuyển khoản ngân hàng qua mã QR, không tích hợp cổng thanh toán tự động.

### 1.2. Mục tiêu hệ thống
- Cung cấp nền tảng mua bán đồ gia dụng trực tuyến dễ sử dụng
- Hỗ trợ khách hàng tìm kiếm và so sánh sản phẩm hiệu quả
- Quản lý đơn hàng và xác nhận thanh toán thủ công qua ảnh chuyển khoản
- Tối ưu trải nghiệm người dùng trên mọi thiết bị
- Dễ dàng quản trị và bảo trì

### 1.3. Phạm vi hệ thống
**Bao gồm:**
- Quản lý sản phẩm đồ gia dụng (nhà bếp, phòng ngủ, phòng khách, phòng tắm...)
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
┌─────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐ │
│  │   Web        │  │   Mobile     │  │   Tablet         │ │
│  │   Browser    │  │   Browser    │  │   Browser        │ │
│  └──────────────┘  └──────────────┘  └──────────────────┘ │
└─────────────────────────────────────────────────────────┘
                            │
                            ↓ HTTPS
┌─────────────────────────────────────────────────────────┐
│                    WEB SERVER (Nginx/Apache)                │
└─────────────────────────────────────────────────────────┘
                            │
                            ↓
┌─────────────────────────────────────────────────────────┐
│                   APPLICATION LAYER (Laravel)               │
│  ┌────────────────────────────────────────────────────┐ │
│  │                    Routes & Middleware                │ │
│  └────────────────────────────────────────────────────┘ │
│  ┌────────────────────────────────────────────────────┐ │
│  │                     Controllers                       │ │
│  │  • ProductController  • OrderController               │ │
│  │  • CartController     • PaymentController             │ │
│  │  • UserController     • ReviewController              │ │
│  └────────────────────────────────────────────────────┘ │
│  ┌────────────────────────────────────────────────────┐ │
│  │                   Business Logic                      │ │
│  │  • Services       • Repositories                      │ │
│  └────────────────────────────────────────────────────┘ │
│  ┌────────────────────────────────────────────────────┐ │
│  │                   Models (Eloquent)                   │ │
│  └────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
                            │
                            ↓
┌─────────────────────────────────────────────────────────┐
│                     DATA LAYER (MySQL)                      │
│  • Products    • Orders      • Users                        │
│  • Categories  • Payments    • Reviews                      │
└─────────────────────────────────────────────────────────┘
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
                            ┌───────┴───────┐
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
- VD: Nhà bếp > Nồi > Nồi cơm điện
- Relationship: 1-n với products, self-reference
- Index: slug, parent_id

**3. brands** (Thương hiệu)
- Thông tin nhà sản xuất (Lock&Lock, Elmich, Sunhouse...)
- Relationship: 1-n với products
- Index: slug

**4. products** (Sản phẩm)
- Thông tin chi tiết đồ gia dụng
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

### 3.3. Thiết kế chi tiết các bảng

#### 3.3.1. Bảng: users
```sql
CREATE TABLE users (
                       id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                       name VARCHAR(255) NOT NULL,
                       email VARCHAR(255) UNIQUE NOT NULL,
                       email_verified_at TIMESTAMP NULL,
                       password VARCHAR(255) NOT NULL,
                       role ENUM('admin', 'customer') DEFAULT 'customer',
                       phone VARCHAR(20),
                       avatar VARCHAR(255),
                       address TEXT,
                       province VARCHAR(100),
                       district VARCHAR(100),
                       ward VARCHAR(100),
                       status ENUM('active', 'inactive') DEFAULT 'active',
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                       INDEX idx_code (code),
                       INDEX idx_status (status),
                       INDEX idx_valid_dates (valid_from, valid_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.13. Bảng: banners
```sql
CREATE TABLE banners (
                         id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                         title VARCHAR(255) NOT NULL,
                         image VARCHAR(255) NOT NULL,
                         link VARCHAR(255),
                         position ENUM('home_slider', 'home_banner', 'sidebar', 'category_top') DEFAULT 'home_slider',
                         display_order INT DEFAULT 0,
                         valid_from TIMESTAMP NULL,
                         valid_until TIMESTAMP NULL,
                         status ENUM('active', 'inactive') DEFAULT 'active',
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                         INDEX idx_position (position),
                         INDEX idx_status (status),
                         INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.14. Bảng: posts
```sql
CREATE TABLE posts (
                       id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                       author_id BIGINT UNSIGNED NOT NULL,
                       title VARCHAR(255) NOT NULL,
                       slug VARCHAR(255) UNIQUE NOT NULL,
                       excerpt VARCHAR(500),
                       content TEXT NOT NULL,
                       featured_image VARCHAR(255),
                       status ENUM('draft', 'published') DEFAULT 'draft',
                       published_at TIMESTAMP NULL,
                       view_count INT DEFAULT 0,
                       meta_title VARCHAR(255),
                       meta_description TEXT,
                       meta_keywords VARCHAR(255),
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                       INDEX idx_slug (slug),
                       INDEX idx_status (status),
                       INDEX idx_author_id (author_id),
                       INDEX idx_published_at (published_at),
                       FULLTEXT idx_search (title, content),
                       FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.15. Bảng: wishlists
```sql
CREATE TABLE wishlists (
                           id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                           user_id BIGINT UNSIGNED NOT NULL,
                           product_id BIGINT UNSIGNED NOT NULL,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                           UNIQUE KEY unique_wishlist (user_id, product_id),
                           INDEX idx_user_id (user_id),
                           INDEX idx_product_id (product_id),
                           FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                           FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3.4. Indexes và Optimization

**Indexes cần thiết:**
```sql
-- Products
ALTER TABLE products ADD INDEX idx_category_brand (category_id, brand_id);
ALTER TABLE products ADD INDEX idx_price_range (price, sale_price);
ALTER TABLE products ADD INDEX idx_featured_status (is_featured, status);
ALTER TABLE products ADD FULLTEXT idx_product_search (name, description);

-- Orders
ALTER TABLE orders ADD INDEX idx_user_status (user_id, order_status);
ALTER TABLE orders ADD INDEX idx_payment_filter (payment_status, order_status);
ALTER TABLE orders ADD INDEX idx_date_range (created_at, order_status);

-- Reviews
ALTER TABLE reviews ADD INDEX idx_product_status (product_id, status);
ALTER TABLE reviews ADD INDEX idx_rating_status (rating, status);

-- Payment Proofs
ALTER TABLE payment_proofs ADD INDEX idx_pending_verification (status, created_at);
```

**Query Optimization:**
- Sử dụng Eager Loading cho relationships để tránh N+1 query
- Cache danh sách categories, brands (TTL: 1 giờ)
- Pagination cho danh sách sản phẩm (15-20 items/page)
- Index cho các cột thường dùng trong WHERE, JOIN, ORDER BY
- FULLTEXT index cho tìm kiếm sản phẩm

## 4. THIẾT KẾ CHỨC NĂNG CHI TIẾT

### 4.1. Module Quản lý Sản phẩm

#### 4.1.1. Chức năng Admin

**Danh sách sản phẩm:**
- Hiển thị bảng với phân trang (20 items/page)
- Cột hiển thị:
    - ID, Ảnh, Tên sản phẩm
    - Danh mục, Thương hiệu
    - Giá, Giá KM
    - Số lượng tồn
    - Trạng thái
    - Lượt xem, Đã bán
    - Thao tác
- Tìm kiếm:
    - Theo tên sản phẩm (FULLTEXT search)
    - Theo SKU
    - Theo danh mục (dropdown với cấu trúc cây)
    - Theo thương hiệu (multi-select)
- Lọc:
    - Trạng thái: Active, Inactive, Out of stock
    - Khoảng giá (slider)
    - Số lượng tồn (< 10, 10-50, > 50)
    - Sản phẩm nổi bật
    - Sản phẩm mới
- Sắp xếp:
    - Theo tên (A-Z, Z-A)
    - Theo giá (tăng/giảm)
    - Theo số lượng
    - Theo ngày tạo
    - Theo lượt xem/bán
- Thao tác hàng loạt:
    - Kích hoạt/Vô hiệu hóa
    - Xóa nhiều
    - Export Excel
    - Cập nhật giá hàng loạt

**Thêm/Sửa sản phẩm:**

*Tab 1: Thông tin cơ bản*
```
┌────────────────────────────────────────┐
│ Tên sản phẩm: [_____________________] │
│ Slug: [___________________________]    │
│ SKU: [____________]                    │
│                                        │
│ Danh mục: [Select Category Tree]      │
│ Thương hiệu: [Select Brand]           │
│                                        │
│ Mô tả ngắn:                           │
│ [________________________]             │
│                                        │
│ Mô tả chi tiết:                       │
│ [WYSIWYG Editor]                      │
└────────────────────────────────────────┘
```

*Tab 2: Giá & Kho*
```
┌────────────────────────────────────────┐
│ Giá gốc: [____________] VNĐ           │
│ Giá khuyến mãi: [____________] VNĐ    │
│ (Để trống nếu không KM)               │
│                                        │
│ Số lượng tồn kho: [______]            │
│ Cảnh báo tồn thấp: [__] (mặc định 10)│
│                                        │
│ ☐ Sản phẩm nổi bật                    │
│ ☐ Sản phẩm mới                        │
│ ☐ Bán chạy                            │
└────────────────────────────────────────┘
```

*Tab 3: Hình ảnh*
```
┌────────────────────────────────────────┐
│ Ảnh đại diện:                         │
│ [Upload] [Preview]                     │
│                                        │
│ Album ảnh sản phẩm:                   │
│ [Upload Multiple]                      │
│ ┌───┐ ┌───┐ ┌───┐ ┌───┐              │
│ │ 1 │ │ 2 │ │ 3 │ │ 4 │              │
│ └───┘ └───┘ └───┘ └───┘              │
│ [Kéo thả để sắp xếp]                  │
└────────────────────────────────────────┘
```

*Tab 4: Thông số kỹ thuật*
```
┌────────────────────────────────────────┐
│ [+ Thêm thông số]                     │
│                                        │
│ Chất liệu: [________________]  [Xóa] │
│ Dung tích: [________________]  [Xóa] │
│ Công suất: [________________]  [Xóa] │
│ Xuất xứ: [__________________]  [Xóa] │
│ Bảo hành: [_________________]  [Xóa] │
│ Kích thước: [_______________]  [Xóa] │
│ Trọng lượng: [______________]  [Xóa] │
│                                        │
│ (Lưu dưới dạng JSON)                  │
└────────────────────────────────────────┘
```

*Tab 5: SEO*
```
┌────────────────────────────────────────┐
│ Meta Title: [_____________________]   │
│ (60 ký tự)                            │
│                                        │
│ Meta Description:                      │
│ [_________________________________]   │
│ (160 ký tự)                           │
│                                        │
│ Meta Keywords:                         │
│ [_________________________________]   │
│ (Cách nhau bởi dấu phẩy)              │
└────────────────────────────────────────┘
```

**Validation:**
```php
'name' => 'required|string|max:255',
'slug' => 'required|string|max:255|unique:products,slug,' . $id,
'sku' => 'nullable|string|max:100|unique:products,sku,' . $id,
'category_id' => 'required|exists:categories,id',
'brand_id' => 'nullable|exists:brands,id',
'price' => 'required|numeric|min:0',
'sale_price' => 'nullable|numeric|min:0|lt:price',
'quantity' => 'required|integer|min:0',
'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
'short_description' => 'nullable|string|max:500',
'description' => 'nullable|string',
'specifications' => 'nullable|json'
```

#### 4.1.2. Chức năng Customer

**Danh sách sản phẩm:**

Layout:
```
┌──────────────────────────────────────────────────┐
│  [Breadcrumb: Trang chủ > Nhà bếp > Nồi cơm]   │
├────────┬─────────────────────────────────────────┤
│        │ [Grid ⊞] [List ☰]  [Sort ▼] 45 sản phẩm│
│ FILTER │ ┌────┬────┬────┬────┐                   │
│        │ │Pro │Pro │Pro │Pro │                   │
│ Danh   │ │ 1  │ 2  │ 3  │ 4  │                   │
│ mục    │ └────┴────┴────┴────┘                   │
│ ☐ Nồi  │ ┌────┬────┬────┬────┐                   │
│ ☐ Chảo │ │Pro │Pro │Pro │Pro │                   │
│ ☐ Dao  │ │ 5  │ 6  │ 7  │ 8  │                   │
│        │ └────┴────┴────┴────┘                   │
│ Giá    │                                          │
│ [═══○══]│ [← 1 2 3 4 5 →]                        │
│ 0 - 5tr│                                          │
│        │                                          │
│ Thương │                                          │
│ hiệu   │                                          │
│ ☐ L&L  │                                          │
│ ☐ Elmich│                                          │
└────────┴─────────────────────────────────────────┘
```

**Product Card (Grid view):**
```
┌────────────────────┐
│   [New] [Sale 20%] │
│                    │
│    [Product Img]   │
│                    │
│ Lock&Lock          │
│ Nồi cơm điện 1.8L │
│                    │
│ ⭐⭐⭐⭐⭐ (24)       │
│                    │
│ 1.590.000đ         │
│ ̶1̶.̶9̶9̶0̶.̶0̶0̶0̶đ̶         │
│                    │
│ [♡] [👁] [🛒 Mua]  │
└────────────────────┘
```

**Chi tiết sản phẩm:**

```
┌──────────────────────────────────────────────────┐
│ [Home > Nhà bếp > Nồi > Nồi cơm điện]         │
├──────────────┬───────────────────────────────────┤
│              │ Lock&Lock Premium                 │
│              │ Nồi cơm điện thông minh 1.8L     │
│  [Main Img]  │                                   │
│              │ ⭐⭐⭐⭐⭐ 4.8 (147 đánh giá)        │
│              │ SKU: LL-RC-1800                   │
│  ┌─┐ ┌─┐ ┌─┐│ ✓ Còn hàng (235 sản phẩm)        │
│  │1│ │2│ │3││                                   │
│  └─┘ └─┘ └─┘│ 1.590.000đ  ̶1̶.̶9̶9̶0̶.̶0̶0̶0̶đ̶        │
│  ┌─┐ ┌─┐ ┌─┐│ Tiết kiệm: 400.000đ (20%)        │
│  │4│ │5│ │6││                                   │
│  └─┘ └─┘ └─┘│ [Mô tả ngắn về sản phẩm...]      │
│              │                                   │
│              │ Số lượng: [➖] [1] [➕]            │
│              │                                   │
│              │ [🛒 Thêm vào giỏ] [💳 Mua ngay]  │
│              │                                   │
│              │ 📦 Miễn phí vận chuyển >500k     │
│              │ ↩ Đổi trả trong 7 ngày            │
│              │ ✓ Bảo hành 12 tháng              │
├──────────────┴───────────────────────────────────┤
│ [Mô tả] [Thông số] [Đánh giá] [Hỏi đáp]       │
├──────────────────────────────────────────────────┤
│ [Nội dung tab được chọn]                        │
└──────────────────────────────────────────────────┘
│                                                  │
│ SẢN PHẨM TƯƠNG TỰ                               │
│ ┌────┬────┬────┬────┐                          │
│ │Pro │Pro │Pro │Pro │                          │
│ └────┴────┴────┴────┘                          │
└──────────────────────────────────────────────────┘
```

**Tab Thông số kỹ thuật:**
```
┌────────────────────────────────────────┐
│ THÔNG SỐ KỸ THUẬT                     │
├────────────────────────────────────────┤
│ Chất liệu:      Thép không gỉ 304     │
│ Dung tích:      1.8L (phục vụ 4-6 người)│
│ Công suất:      750W                   │
│ Chức năng:      Nấu cơm, Hâm nóng,    │
│                 Hẹn giờ, Giữ ấm       │
│ Lòng nồi:       Chống dính Marble     │
│ Xuất xứ:        Việt Nam              │
│ Bảo hành:       12 tháng chính hãng   │
│ Kích thước:     30 x 25 x 20 cm       │
│ Trọng lượng:    2.5kg                 │
└────────────────────────────────────────┘
```

**Tìm kiếm sản phẩm:**
- Search bar ở header (sticky)
- Autocomplete gợi ý khi gõ (debounce 300ms)
- Hiển thị:
    - Gợi ý sản phẩm (5 items) với ảnh + giá
    - Gợi ý danh mục (3 items)
    - "Xem tất cả kết quả" link
- Search results page:
    - Hiển thị từ khóa đã tìm
    - Highlight từ khóa trong kết quả
    - Filter sidebar tương tự trang category
    - Sắp xếp theo độ liên quan

**So sánh sản phẩm:**
```
Chức năng:
1. Checkbox "So sánh" ở product card
2. Sticky bar bottom hiển thị sản phẩm đã chọn (max 4)
3. Click "So sánh ngay" → trang so sánh

Trang so sánh:
┌──────────────────────────────────────────────────┐
│ SO SÁNH SẢN PHẨM                                │
├────────┬────────┬────────┬────────┬────────────┤
│        │ Pro 1  │ Pro 2  │ Pro 3  │ Pro 4      │
├────────┼────────┼────────┼────────┼────────────┤
│ Ảnh    │ [img]  │ [img]  │ [img]  │ [img]      │
│ Tên    │ ...    │ ...    │ ...    │ ...        │
│ Giá    │ 1.5tr  │ 2.0tr  │ 1.8tr  │ 2.5tr      │
│ Rating │ ⭐4.5   │ ⭐4.8   │ ⭐4.2   │ ⭐4.9       │
├────────┼────────┼────────┼────────┼────────────┤
│ Chất   │ Inox   │ Nhôm   │ Inox   │ Ceramic    │
│ liệu   │        │        │        │            │
│ Dung   │ 1.8L   │ 2.0L   │ 1.5L   │ 2.2L       │
│ tích   │        │        │        │            │
│ ...    │        │        │        │            │
├────────┼────────┼────────┼────────┼────────────┤
│        │[🛒 Mua]│[🛒 Mua]│[🛒 Mua]│[🛒 Mua]    │
└────────┴────────┴────────┴────────┴────────────┘
```

### 4.2. Module Giỏ hàng & Đặt hàng

#### 4.2.1. Giỏ hàng

**Lưu trữ giỏ hàng:**

**Phương án 1: Session-based (Khách chưa đăng nhập)**
- Lưu trữ: Session/Cookie của browser
- Ưu điểm:
    - Không cần đăng nhập
    - Xử lý nhanh
    - Giảm tải database
- Nhược điểm:
    - Mất dữ liệu khi xóa cookie/đổi thiết bị
    - Không đồng bộ nhiều thiết bị
    - Khó tracking hành vi khách hàng

**Phương án 2: Database-based (Khách đã đăng nhập)**
- Lưu trữ: Bảng cart_items trong MySQL
- Ưu điểm:
    - Giữ giỏ hàng lâu dài
    - Đồng bộ nhiều thiết bị
    - Tracking được hành vi khách
    - Có thể gửi email nhắc nhở
- Nhược điểm:
    - Bắt buộc đăng nhập
    - Tăng query database

**Chiến lược kết hợp:**
- Chưa đăng nhập → Session
- Đã đăng nhập → Database
- Khi đăng nhập → Merge session vào database
- TTL giỏ hàng: 30 ngày (tự động xóa sau 30 ngày không hoạt động)

**Nghiệp vụ giỏ hàng:**

*Giao diện giỏ hàng:*
```
┌──────────────────────────────────────────────────────────┐
│ GIỎ HÀNG CỦA BẠN (3 sản phẩm)                           │
├──────────────────────────────────────────────────────────┤
│ ┌──────────────────────────────────────────────────────┐ │
│ │ [✓] [Img] Nồi cơm điện Lock&Lock 1.8L              │ │
│ │           SKU: LL-RC-1800                            │ │
│ │           Màu: Đỏ | Size: 1.8L                       │ │
│ │           1.590.000đ x [➖] [2] [➕] = 3.180.000đ     │ │
│ │           Còn 235 sản phẩm                           │ │
│ │           [Yêu thích] [Xóa]                          │ │
│ └──────────────────────────────────────────────────────┘ │
│ ┌──────────────────────────────────────────────────────┐ │
│ │ [✓] [Img] Bộ nồi inox Elmich 3 chiếc               │ │
│ │           SKU: EL-POT-SET3                           │ │
│ │           1.290.000đ x [➖] [1] [➕] = 1.290.000đ     │ │
│ │           Còn 45 sản phẩm                            │ │
│ │           [Yêu thích] [Xóa]                          │ │
│ └──────────────────────────────────────────────────────┘ │
│ ┌──────────────────────────────────────────────────────┐ │
│ │ [✗] [Img] Chảo chống dính Tefal 28cm [HẾT HÀNG]    │ │
│ │           890.000đ - Tạm thời hết hàng               │ │
│ │           [Nhận thông báo] [Xóa]                     │ │
│ └──────────────────────────────────────────────────────┘ │
│                                                          │
│ ┌────────────────────────────────────────────────────┐   │
│ │ 📦 Mã giảm giá                                     │   │
│ │ [Nhập mã giảm giá_________] [Áp dụng]             │   │
│ │                                                     │   │
│ │ 💰 Tạm tính:               4.470.000đ              │   │
│ │ 🎫 Giảm giá:              -  470.000đ (GIAM10)     │   │
│ │ 🚚 Phí vận chuyển:         Miễn phí                │   │
│ │ ═══════════════════════════════════════            │   │
│ │ 💵 Tổng cộng:              4.000.000đ              │   │
│ │                                                     │   │
│ │ [⬅ Tiếp tục mua hàng]  [Thanh toán ➡]             │   │
│ └────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────┘
```

**Nghiệp vụ xử lý giỏ hàng chi tiết:**

**1. Thêm sản phẩm vào giỏ:**

*Quy trình nghiệp vụ:*
- Bước 1: Kiểm tra sản phẩm có tồn tại không
- Bước 2: Kiểm tra trạng thái sản phẩm (active/inactive)
- Bước 3: Kiểm tra tồn kho
    - Nếu quantity = 0 → Thông báo "Hết hàng"
    - Nếu quantity < số lượng yêu cầu → Thông báo "Chỉ còn X sản phẩm"
- Bước 4: Kiểm tra giới hạn mua
    - Mỗi sản phẩm tối đa 10 cái/đơn hàng
    - Mục đích: Tránh mua sỉ, đảm bảo công bằng
- Bước 5: Kiểm tra sản phẩm đã có trong giỏ chưa
    - Nếu có → Cộng dồn số lượng
    - Nếu chưa → Thêm mới
- Bước 6: Cập nhật giỏ hàng
    - Đã đăng nhập → Lưu vào database
    - Chưa đăng nhập → Lưu vào session
- Bước 7: Trả về kết quả
    - Thông báo thành công
    - Số lượng sản phẩm trong giỏ (hiển thị badge)

*Xử lý đặc biệt:*
- **Sản phẩm đang sale:** Lưu cả giá gốc và giá sale
- **Sản phẩm combo:** Kiểm tra tồn kho của tất cả item trong combo
- **Sản phẩm có biến thể:** (Nếu có) Kiểm tra từng biến thể riêng

**2. Cập nhật số lượng:**

*Quy trình nghiệp vụ:*
- Trigger: User thay đổi số lượng (input number hoặc +/-)
- Validation realtime (AJAX):
    - Số lượng >= 1
    - Số lượng <= tồn kho hiện tại
    - Số lượng <= giới hạn cho phép (10)
- Cập nhật tức thì:
    - Số lượng sản phẩm
    - Thành tiền từng dòng
    - Tạm tính tổng đơn
    - Giảm giá (nếu có mã)
    - Phí ship (nếu có)
    - Tổng cuối cùng
- Xử lý lỗi:
    - Nếu vượt tồn kho → Tự động điều chỉnh về max
    - Nếu < 1 → Hỏi xác nhận xóa

*Tính năng nâng cao:*
- Debounce 500ms để tránh spam request
- Optimistic UI update (cập nhật UI trước, sau đó gọi API)
- Loading state khi đang xử lý

**3. Xóa sản phẩm:**

*Quy trình nghiệp vụ:*
- Click nút "Xóa"
- Hiển thị confirm dialog (optional)
- Xóa khỏi database/session
- Cập nhật lại tổng đơn
- Hiển thị thông báo "Đã xóa khỏi giỏ"
- Có nút "Hoàn tác" trong 5 giây (optional)

*Xử lý đặc biệt:*
- Nếu xóa hết → Hiển thị "Giỏ hàng trống" với link về trang sản phẩm
- Nếu sản phẩm đang áp dụng trong combo deal → Cảnh báo

**4. Áp dụng mã giảm giá:**

*Quy trình validation:*
- Bước 1: Kiểm tra mã có tồn tại không
- Bước 2: Kiểm tra trạng thái mã (active/inactive)
- Bước 3: Kiểm tra thời hạn hiệu lực
    - valid_from <= hiện tại <= valid_until
- Bước 4: Kiểm tra số lần sử dụng
    - used_count < usage_limit
- Bước 5: Kiểm tra giá trị đơn hàng tối thiểu
    - subtotal >= min_order_amount
- Bước 6: Kiểm tra điều kiện áp dụng (nếu có)
    - Chỉ cho khách hàng mới
    - Chỉ cho danh mục cụ thể
    - Chỉ cho sản phẩm cụ thể
- Bước 7: Tính toán giảm giá
    - Type = percentage: discount = subtotal * value / 100
    - Type = fixed: discount = value
    - Nếu có max_discount_amount: discount = min(discount, max_discount_amount)
- Bước 8: Lưu mã vào session/order
- Bước 9: Cập nhật tổng đơn

*Thông báo cho user:*
- Thành công: "Đã áp dụng mã GIAM10. Giảm 100.000đ"
- Lỗi cụ thể:
    - "Mã không tồn tại"
    - "Mã đã hết hạn"
    - "Mã đã hết lượt sử dụng"
    - "Đơn hàng chưa đủ 500.000đ để áp dụng mã này"

**5. Tính tổng giỏ hàng:**

*Công thức tính:*
```
Tạm tính = Σ(price × quantity) của các sản phẩm available

Giảm giá = Tính theo mã coupon (nếu có)
  - Type percentage: (Tạm tính × value%) nhưng tối đa max_discount_amount
  - Type fixed: value cố định

Phí vận chuyển = 
  - 0đ nếu (Tạm tính - Giảm giá) >= 500.000đ
  - 30.000đ nếu < 500.000đ

Tổng cộng = Tạm tính - Giảm giá + Phí vận chuyển
```

*Xử lý sản phẩm unavailable:*
- Hiển thị riêng danh sách sản phẩm hết hàng
- Không tính vào tổng đơn
- Đề xuất: "Xóa" hoặc "Nhận thông báo khi có hàng"

**6. Validate giỏ hàng trước khi checkout:**

*Checklist validation:*
- ☑ Giỏ hàng không rỗng
- ☑ Tất cả sản phẩm đều còn kinh doanh (status = active)
- ☑ Tất cả sản phẩm đều còn hàng (quantity > 0)
- ☑ Số lượng từng sản phẩm <= tồn kho
- ☑ Giá sản phẩm không thay đổi bất thường (tăng đột biến)
- ☑ Mã giảm giá vẫn còn hiệu lực (nếu có)
- ☑ Tổng đơn >= giá trị tối thiểu cho phép (VD: 50.000đ)

*Xử lý khi có lỗi:*
- Hiển thị popup chi tiết các vấn đề
- Tự động loại bỏ sản phẩm hết hàng
- Tự động điều chỉnh số lượng vượt tồn
- Yêu cầu user xác nhận lại

**7. Merge giỏ hàng khi đăng nhập:**

*Kịch bản:*
- User thêm sản phẩm vào giỏ (chưa đăng nhập → Session)
- User đăng nhập
- Hệ thống merge giỏ từ session vào database

*Quy trình merge:*
- Bước 1: Lấy giỏ hàng từ session
- Bước 2: Lấy giỏ hàng từ database của user
- Bước 3: Với mỗi sản phẩm trong session:
    - Nếu đã có trong database → Cộng dồn số lượng
    - Nếu chưa có → Thêm mới vào database
- Bước 4: Kiểm tra và điều chỉnh số lượng nếu vượt tồn
- Bước 5: Xóa giỏ hàng trong session
- Bước 6: Hiển thị thông báo cho user (nếu có thay đổi)

*Xử lý conflict:*
- Nếu tổng số lượng > tồn kho → Lấy tối đa tồn kho
- Nếu sản phẩm đã hết hàng → Thông báo cho user

**8. Xử lý sản phẩm hết hàng trong giỏ:**

*Phát hiện:*
- Khi user vào trang giỏ hàng
- Khi user cập nhật số lượng
- Khi user checkout

*Hiển thị:*
- Badge "Hết hàng" màu đỏ
- Làm mờ sản phẩm (opacity 0.5)
- Disable checkbox và nút +/-
- Không tính vào tổng đơn

*Hành động:*
- Nút "Xóa" → Xóa khỏi giỏ
- Nút "Nhận thông báo" → Lưu email để báo khi có hàng

**9. Xử lý thay đổi giá:**

*Kịch bản:*
- Sản phẩm trong giỏ có giá 1.000.000đ
- Admin thay đổi giá thành 1.200.000đ
- User checkout

*Giải pháp:*
- **Cách 1:** Cập nhật giá realtime
    - Khi user vào giỏ → Lấy giá mới nhất từ DB
    - Hiển thị thông báo "Giá đã thay đổi"
    - Yêu cầu user xác nhận lại

- **Cách 2:** Giữ nguyên giá cũ trong session
    - Chỉ update khi user refresh trang
    - Rủi ro: User mua được giá cũ

- **Khuyến nghị:** Dùng cách 1 + Thông báo rõ ràng

**10. Giỏ hàng bỏ quên (Abandoned Cart):**

*Tracking:*
- Lưu thời điểm tạo giỏ hàng
- Lưu thời điểm cập nhật cuối cùng
- Đánh dấu trạng thái: active, abandoned, converted

*Quy tắc:*
- Giỏ hàng không hoạt động trong 24h → abandoned
- Giỏ hàng không hoạt động trong 30 ngày → Xóa tự động

*Recovery strategy:*
- Gửi email nhắc nhở sau 2h (nếu có email)
- Gửi email với mã giảm giá sau 24h
- Hiển thị popup khi user quay lại

#### 4.2.2. Quy trình đặt hàng chi tiết

**Luồng tổng quan:**
```
[Giỏ hàng] → [Thông tin giao hàng] → [Xác nhận] → [Thanh toán] → [Hoàn tất]
```

**Bước 1: Từ giỏ hàng đến checkout**

*Điều kiện:*
- Giỏ hàng có ít nhất 1 sản phẩm available
- Tổng đơn >= 50.000đ (giá trị tối thiểu)

*Khi click "Thanh toán":*
- Validate giỏ hàng một lần nữa
- Nếu chưa đăng nhập → Hiển thị 2 options:
    - "Đăng nhập" → Form login
    - "Tiếp tục với vai trò khách" → Form thông tin
- Nếu đã đăng nhập → Chuyển thẳng sang bước 2

**Bước 2: Nhập thông tin giao hàng**

*Form layout:*
```
┌──────────────────────────────────────────────────────────┐
│ THÔNG TIN GIAO HÀNG                                      │
├──────────────────────────────────────────────────────────┤
│ ○ Đăng nhập để mua hàng nhanh hơn [Đăng nhập]           │
│ ● Tiếp tục với vai trò khách                            │
│                                                          │
│ Họ và tên (*): [_________________________________]      │
│                                                          │
│ Số điện thoại (*): [_________________________________]  │
│                                                          │
│ Email (*): [_________________________________________]  │
│                                                          │
│ Tỉnh/Thành phố (*): [Select ▼]                         │
│                                                          │
│ Quận/Huyện (*): [Select ▼]                             │
│                                                          │
│ Phường/Xã (*): [Select ▼]                              │
│                                                          │
│ Địa chỉ chi tiết (*): [____________________________]   │
│ (Số nhà, tên đường)                                     │
│                                                          │
│ Ghi chú đơn hàng: [________________________________]   │
│ (VD: Giao giờ hành chính, gọi trước 15 phút...)       │
│                                                          │
│ ☐ Lưu thông tin để mua hàng nhanh hơn lần sau          │
│                                                          │
│ [⬅ Quay lại]              [Tiếp tục ➡]                 │
└──────────────────────────────────────────────────────────┘
```

*Nghiệp vụ xử lý:*

**1. Tự động điền thông tin (Autofill):**
- Nếu đã đăng nhập và có địa chỉ trong profile:
    - Tự động điền các trường
    - Cho phép chỉnh sửa
    - Hiển thị option "Giao đến địa chỉ khác"
- Nếu có nhiều địa chỉ:
    - Hiển thị danh sách địa chỉ đã lưu
    - Radio button chọn địa chỉ
    - Nút "Thêm địa chỉ mới"

**2. Validate Realtime:**
- Họ tên:
    - Required
    - Min 3 ký tự
    - Chỉ chứa chữ cái và khoảng trắng
    - Max 255 ký tự

- Số điện thoại:
    - Required
    - Format: 10-11 số
    - Bắt đầu bằng 0
    - Regex: ^(0[3|5|7|8|9])+([0-9]{8})$

- Email:
    - Required
    - Format email chuẩn RFC
    - Check domain tồn tại (optional)

- Địa chỉ:
    - Tỉnh/Thành: Required, chọn từ danh sách
    - Quận/Huyện: Required, load động theo Tỉnh
    - Phường/Xã: Required, load động theo Quận
    - Địa chỉ chi tiết: Required, min 10 ký tự

**3. Xử lý dữ liệu địa giới hành chính:**

*Cấu trúc dữ liệu:*
- Bảng provinces: 63 tỉnh/thành
- Bảng districts: ~700 quận/huyện
- Bảng wards: ~11.000 phường/xã

*Quy trình load:*
- Ban đầu: Load danh sách tỉnh/thành
- Chọn tỉnh → AJAX load danh sách quận/huyện
- Chọn quận → AJAX load danh sách phường/xã
- Cache kết quả để tăng performance

*Tính phí ship (nếu có):*
- Theo khu vực:
    - Nội thành: Miễn phí
    - Ngoại thành: 30.000đ
    - Tỉnh khác: 50.000đ
- Hoặc miễn phí với đơn >= 500k

**Bước 3: Chọn phương thức thanh toán**

*Giao diện:*
```
┌──────────────────────────────────────────────────────────┐
│ PHƯƠNG THỨC THANH TOÁN                                   │
├──────────────────────────────────────────────────────────┤
│ ● Chuyển khoản ngân hàng (Khuyên dùng)                  │
│   • Chuyển khoản theo QR Code                           │
│   • Xác nhận nhanh chóng                                │
│   • Được ưu tiên xử lý                                  │
│                                                          │
│ ○ Thanh toán khi nhận hàng (COD)                        │
│   • Thanh toán bằng tiền mặt khi nhận hàng             │
│   • Phí COD: 20.000đ                                    │
│   • Chỉ áp dụng đơn < 5.000.000đ                        │
│                                                          │
└──────────────────────────────────────────────────────────┘
```

*Nghiệp vụ xử lý:*

**1. Phương thức chuyển khoản:**
- Mặc định được chọn
- Không phát sinh phí thêm
- Ưu tiên xử lý đơn hàng
- Yêu cầu upload chứng từ sau khi đặt

**2. Phương thức COD:**
- Thu phí 20.000đ
- Giới hạn:
    - Đơn hàng < 5.000.000đ
    - Chỉ giao trong nội thành (có thể cấu hình)
- Validate: Kiểm tra điều kiện trước khi cho phép chọn
- Rủi ro cao hơn (hàng hoàn, từ chối nhận...)

**Bước 4: Xác nhận đơn hàng**

*Giao diện review:*
```
┌──────────────────────────────────────────────────────────┐
│ XÁC NHẬN ĐƠN HÀNG                                        │
├──────────────────────────────────────────────────────────┤
│ 📦 Thông tin sản phẩm                                   │
│ ┌────────────────────────────────────────────────────┐  │
│ │ [Img] Nồi cơm điện Lock&Lock 1.8L                 │  │
│ │       1.590.000đ x 2 = 3.180.000đ                  │  │
│ ├────────────────────────────────────────────────────┤  │
│ │ [Img] Bộ nồi inox Elmich 3 chiếc                  │  │
│ │       1.290.000đ x 1 = 1.290.000đ                  │  │
│ └────────────────────────────────────────────────────┘  │
│                                                          │
│ 📍 Thông tin giao hàng                                  │
│ Người nhận: Nguyễn Văn A                                │
│ Điện thoại: 0901234567                                  │
│ Email: email@example.com                                 │
│ Địa chỉ: 123 Đường ABC, Phường X, Quận Y, TP.HCM       │
│ Ghi chú: Giao giờ hành chính                            │
│                                                          │
│ 💳 Phương thức thanh toán                               │
│ Chuyển khoản ngân hàng                                  │
│                                                          │
│ 💰 Chi tiết thanh toán                                  │
│ ┌────────────────────────────────────────────────────┐  │
│ │ Tạm tính:              4.470.000đ                  │  │
│ │ Giảm giá (GIAM10):    -  470.000đ                  │  │
│ │ Phí vận chuyển:         Miễn phí                   │  │
│ │ ═══════════════════════════════════════            │  │
│ │ Tổng cộng:             4.000.000đ                  │  │
│ └────────────────────────────────────────────────────┘  │
│                                                          │
│ ☑ Tôi đã đọc và đồng ý với Điều khoản sử dụng          │
│                                                          │
│ [⬅ Quay lại]          [ĐẶT HÀNG]                       │
└──────────────────────────────────────────────────────────┘
```

*Nghiệp vụ xử lý:*

**1. Validate lần cuối:**
- Kiểm tra lại tồn kho realtime
- Kiểm tra giá sản phẩm có thay đổi không
- Kiểm tra mã giảm giá còn hiệu lực
- Kiểm tra thông tin đầy đủ hợp lệ

**2. Xử lý concurrency (đồng thời):**
- Kịch bản: 2 user cùng mua sản phẩm cuối cùng
- Giải pháp:
    - Sử dụng Database Transaction
    - Lock row khi giảm số lượng (FOR UPDATE)
    - User nào commit trước được mua
    - User sau báo "Hết hàng"

**3. Tạo đơn hàng:**

*Quy trình chi tiết:*

Step 1: Bắt đầu Transaction
```
BEGIN TRANSACTION
```

Step 2: Tạo Order
- Generate order_number unique (VD: DH20241215001)
- Lưu thông tin khách hàng
- Lưu thông tin giao hàng
- Lưu chi tiết thanh toán (subtotal, discount, shipping, total)
- Lưu mã giảm giá (nếu có)
- Set status:
    - order_status = 'pending'
    - payment_status = 'pending'
- Set payment_method

Step 3: Tạo Order Items
- Với mỗi sản phẩm trong giỏ:
    - Lưu product_id, product_name, sku
    - Lưu giá tại thời điểm mua (price snapshot)
    - Lưu quantity, subtotal
    - Lưu ảnh sản phẩm

Step 4: Giảm tồn kho
- Với mỗi sản phẩm:
    - UPDATE products
    - SET quantity = quantity - order_quantity
    - WHERE id = product_id AND quantity >= order_quantity
    - Kiểm tra affected_rows = 1 (thành công)
    - Nếu = 0 → Rollback (hết hàng)

Step 5: Tăng sold_count
- UPDATE products
- SET sold_count = sold_count + order_quantity

Step 6: Cập nhật coupon usage
- Nếu có dùng coupon:
    - UPDATE coupons
    - SET used_count = used_count + 1
    - WHERE code = coupon_code

Step 7: Xóa giỏ hàng
- Nếu đã đăng nhập: DELETE cart_items
- Nếu chưa: Session::forget('cart')

Step 8: Commit Transaction
```
COMMIT
```

Step 9: Gửi email xác nhận
- Gửi cho khách hàng:
    - Thông tin đơn hàng
    - Mã đơn hàng
    - Chi tiết sản phẩm
    - Hướng dẫn thanh toán
    - Link tra cứu đơn hàng

Step 10: Gửi thông báo cho Admin
- Email/SMS cho admin
- Có đơn hàng mới cần xử lý

*Xử lý lỗi:*
- Nếu bất kỳ step nào fail → ROLLBACK
- Log lỗi chi tiết
- Thông báo cho user: "Đặt hàng thất bại, vui lòng thử lại"
- Giữ nguyên giỏ hàng

**Bước 5: Hiển thị thông tin thanh toán**

*Sau khi đặt hàng thành công:inactive') DEFAULT 'active',
remember_token VARCHAR(100),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.2. Bảng: categories
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    parent_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    icon VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_parent_id (parent_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_order (display_order),
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ví dụ cấu trúc danh mục:
-- Nhà bếp (parent_id = NULL)
--   ├── Nồi, chảo (parent_id = 1)
--   │     ├── Nồi cơm điện (parent_id = 2)
--   │     └── Chảo chống dính (parent_id = 2)
--   ├── Dao, thớt (parent_id = 1)
--   └── Dụng cụ nhà bếp (parent_id = 1)
```

#### 3.3.3. Bảng: brands
```sql
CREATE TABLE brands (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    logo VARCHAR(255),
    description TEXT,
    website VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_slug (slug),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ví dụ: Lock&Lock, Elmich, Sunhouse, Philips, Panasonic...
```

#### 3.3.4. Bảng: products
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT UNSIGNED NOT NULL,
    brand_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    sku VARCHAR(100) UNIQUE,
    description TEXT,
    short_description VARCHAR(500),
    
    -- Giá cả
    price DECIMAL(15,2) NOT NULL,
    sale_price DECIMAL(15,2) NULL,
    
    -- Kho hàng
    quantity INT DEFAULT 0,
    
    -- Hình ảnh
    featured_image VARCHAR(255),
    
    -- Thông số kỹ thuật (JSON)
    specifications JSON,
    /* Ví dụ JSON:
    {
        "material": "Thép không gỉ",
        "capacity": "1.8L",
        "power": "1500W",
        "origin": "Việt Nam",
        "warranty": "12 tháng",
        "dimensions": "30x20x15cm",
        "weight": "2.5kg"
    }
    */
    
    -- Trạng thái
    status ENUM('active', 'inactive', 'out_of_stock') DEFAULT 'active',
    is_featured BOOLEAN DEFAULT FALSE,
    is_new BOOLEAN DEFAULT FALSE,
    is_bestseller BOOLEAN DEFAULT FALSE,
    
    -- SEO
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords VARCHAR(255),
    
    -- Thống kê
    view_count INT DEFAULT 0,
    sold_count INT DEFAULT 0,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_category_id (category_id),
    INDEX idx_brand_id (brand_id),
    INDEX idx_slug (slug),
    INDEX idx_sku (sku),
    INDEX idx_price (price),
    INDEX idx_status (status),
    INDEX idx_featured (is_featured),
    FULLTEXT idx_search (name, description),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.5. Bảng: product_images
```sql
CREATE TABLE product_images (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_product_id (product_id),
    INDEX idx_order (display_order),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.6. Bảng: orders
```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    
    -- Thông tin khách hàng
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    
    -- Địa chỉ giao hàng
    shipping_address TEXT NOT NULL,
    shipping_province VARCHAR(100),
    shipping_district VARCHAR(100),
    shipping_ward VARCHAR(100),
    
    -- Ghi chú
    note TEXT,
    
    -- Tổng tiền
    subtotal DECIMAL(15,2) NOT NULL,
    discount_amount DECIMAL(15,2) DEFAULT 0,
    shipping_fee DECIMAL(15,2) DEFAULT 0,
    total DECIMAL(15,2) NOT NULL,
    
    -- Mã giảm giá
    coupon_id BIGINT UNSIGNED NULL,
    coupon_code VARCHAR(50),
    
    -- Trạng thái đơn hàng
    order_status ENUM('pending', 'confirmed', 'processing', 'shipping', 'delivered', 'cancelled') DEFAULT 'pending',
    
    -- Trạng thái thanh toán
    payment_method ENUM('bank_transfer', 'cod') DEFAULT 'bank_transfer',
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    
    -- Thời gian
    confirmed_at TIMESTAMP NULL,
    shipped_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    
    -- Lý do hủy
    cancel_reason TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_order_number (order_number),
    INDEX idx_order_status (order_status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.7. Bảng: order_items
```sql
CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_sku VARCHAR(100),
    product_image VARCHAR(255),
    price DECIMAL(15,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_order_id (order_id),
    INDEX idx_product_id (product_id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.8. Bảng: payment_proofs
```sql
CREATE TABLE payment_proofs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    transaction_code VARCHAR(100),
    amount DECIMAL(15,2),
    note TEXT,
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    reject_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_order_id (order_id),
    INDEX idx_status (status),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.9. Bảng: bank_accounts
```sql
CREATE TABLE bank_accounts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bank_name VARCHAR(255) NOT NULL,
    bank_code VARCHAR(50),
    account_number VARCHAR(50) NOT NULL,
    account_holder VARCHAR(255) NOT NULL,
    branch VARCHAR(255),
    qr_code_path VARCHAR(255),
    is_default BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_is_default (is_default),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.10. Bảng: reviews
```sql
CREATE TABLE reviews (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    order_id BIGINT UNSIGNED NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    title VARCHAR(255),
    comment TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    is_verified_purchase BOOLEAN DEFAULT FALSE,
    helpful_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_rating (rating),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.11. Bảng: review_images
```sql
CREATE TABLE review_images (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    review_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_review_id (review_id),
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.12. Bảng: coupons
```sql
CREATE TABLE coupons (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('percentage', 'fixed') NOT NULL,
    value DECIMAL(15,2) NOT NULL,
    min_order_amount DECIMAL(15,2) DEFAULT 0,
    max_discount_amount DECIMAL(15,2) NULL,
    usage_limit INT NULL,
    used_count INT DEFAULT 0,
    valid_from TIMESTAMP NULL,
    valid_until TIMESTAMP NULL,
    status ENUM('active', '
