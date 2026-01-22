**Nút hành động:**
- [Lưu nháp]: Lưu tạm, chưa hoàn thành
- [Kê đơn thuốc]: Chuyển sang form kê đơn
- [Hoàn thành]: Lưu và đóng phiếu khám
- [Hủy]: Hủy bỏ phiếu khám
- [In phiếu]: Xuất PDF phiếu khám

**Validation phiếu khám:**
- Lý do khám: Required
- Triệu chứng: Required
- Chẩn đoán: Required
- Sinh hiệu: Kiểm tra giá trị hợp lý
    - Nhiệt độ: 35-42°C
    - Huyết áp tâm thu: 80-200 mmHg
    - Huyết áp tâm trương: 50-130 mmHg
    - Nhịp tim: 40-200 bpm
    - Nhịp thở: 10-40 lần/phút

#### 4.4.2. Kê đơn thuốc (Prescription)

**Form kê đơn thuốc:**

*Giao diện:*
```
┌─────────────────────────────────────────────────────────┐
│ KÊ ĐÔN THUỐC                                           │
│ Phiếu khám: MR-20241218-001                            │
├─────────────────────────────────────────────────────────┤
│ Bệnh nhân: Nguyễn Văn A (39 tuổi)                     │
│ Chẩn đoán: Viêm họng cấp                              │
│                                                         │
│ ⚠️ Dị ứng: Penicillin                                 │
├─────────────────────────────────────────────────────────┤
│ [+ Thêm thuốc]                                         │
│                                                         │
│ ┌─────────────────────────────────────────────────────┐│
│ │ 1. Tên thuốc (*): [Paracetamol 500mg      ]        ││
│ │    Hàm lượng: [500mg                      ]        ││
│ │                                                     ││
│ │    Liều dùng (*): [1 viên               ]          ││
│ │    Tần suất (*): [Ngày 3 lần            ]          ││
│ │    Thời gian: [Sau ăn 30 phút           ]          ││
│ │    Số ngày (*): [7 ngày                 ]          ││
│ │    Số lượng (*): [21 viên               ] (Auto)   ││
│ │                                                     ││
│ │    Hướng dẫn sử dụng:                              ││
│ │    [Uống sau ăn, uống với nhiều nước]              ││
│ │                                                     ││
│ │    Ghi chú:                                        ││
│ │    [Nếu sốt cao trên 39°C, có thể uống thêm]      ││
│ │                                                     ││
│ │    [Xóa thuốc]                                     ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ ┌─────────────────────────────────────────────────────┐│
│ │ 2. Tên thuốc (*): [Amoxicillin 250mg      ]        ││
│ │    Hàm lượng: [250mg                      ]        ││
│ │                                                     ││
│ │    Liều dùng (*): [2 viên               ]          ││
│ │    Tần suất (*): [Ngày 2 lần            ]          ││
│ │    Thời gian: [Sáng và tối sau ăn       ]          ││
│ │    Số ngày (*): [7 ngày                 ]          ││
│ │    Số lượng (*): [28 viên               ]          ││
│ │                                                     ││
│ │    ⚠️ Cảnh báo: Kiểm tra dị ứng Penicillin         ││
│ │    [Chọn thuốc khác]                               ││
│ │                                                     ││
│ │    [Xóa thuốc]                                     ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ LƯU Ý CHUNG:                                           │
│ [___________________________________________________]   │
│ [___________________________________________________]   │
│                                                         │
│ [Lưu đơn thuốc] [In đơn thuốc] [Hủy]                  │
└─────────────────────────────────────────────────────────┘
```

**Tính năng đặc biệt:**

1. **Kiểm tra dị ứng tự động:**
    - Khi chọn thuốc, hệ thống check với danh sách dị ứng của BN
    - Hiển thị cảnh báo nếu phát hiện thuốc có thành phần gây dị ứng
    - Gợi ý thuốc thay thế

2. **Tính toán số lượng tự động:**
    - Công thức: Số lượng = Liều dùng × Số lần/ngày × Số ngày
    - VD: 1 viên × 3 lần × 7 ngày = 21 viên

3. **Template đơn thuốc:**
    - Lưu các đơn thuốc thường dùng
    - Áp dụng nhanh cho bệnh tương tự
    - Tùy chỉnh theo từng bệnh nhân

4. **Gợi ý thuốc:**
    - Dựa trên chẩn đoán
    - Lịch sử kê đơn của bác sĩ
    - Thuốc phổ biến cho bệnh này

**Validation đơn thuốc:**
- Tên thuốc: Required
- Liều dùng: Required, > 0
- Tần suất: Required
- Số ngày: Required, 1-90 ngày
- Số lượng: Required, > 0
- Kiểm tra tương tác thuốc (nếu có)
- Kiểm tra dị ứng bắt buộc

**In đơn thuốc:**

Format PDF gồm:
```
┌─────────────────────────────────────────────┐
│        PHÒNG KHÁM ĐA KHOA ABC               │
│    123 Đường ABC, Quận X, TP.HCM           │
│         ĐT: 028.xxxx.xxxx                   │
├─────────────────────────────────────────────┤
│           ĐƠN THUỐC                         │
├─────────────────────────────────────────────┤
│ Mã đơn: RX-20241218-001                    │
│ Ngày: 18/12/2024                           │
│                                             │
│ Bệnh nhân: NGUYỄN VĂN A                    │
│ Năm sinh: 1985        Giới tính: Nam       │
│ Địa chỉ: 456 Đường XYZ, Quận Y             │
│ Điện thoại: 0901234567                     │
│                                             │
│ Chẩn đoán: Viêm họng cấp                   │
│                                             │
│ THUỐC KÊ ĐƠN:                              │
│                                             │
│ 1. Paracetamol 500mg                       │
│    - Liều dùng: 1 viên                     │
│    - Số lần: 3 lần/ngày                    │
│    - Thời gian: Sau ăn 30 phút             │
│    - Số ngày: 7 ngày                       │
│    - Tổng số lượng: 21 viên                │
│    Hướng dẫn: Uống sau ăn, uống với        │
│               nhiều nước                    │
│                                             │
│ 2. Viên ngậm Strepsils                     │
│    - Liều dùng: 1 viên                     │
│    - Số lần: 4-5 lần/ngày                  │
│    - Số ngày: 5 ngày                       │
│    - Tổng số lượng: 25 viên                │
│    Hướng dẫn: Ngậm từ từ, không nhai       │
│                                             │
│ LƯU Ý:                                     │
│ - Uống đủ nước, nghỉ ngơi                  │
│ - Tái khám sau 7 ngày nếu không đỡ         │
│ - Đến ngay nếu sốt cao trên 39°C           │
│                                             │
│                    Bác sĩ điều trị          │
│                  BS. Nguyễn Văn C          │
│                  (Đã ký điện tử)           │
└─────────────────────────────────────────────┘
```

#### 4.4.3. Hoàn thành khám bệnh

**Quy trình hoàn thành:**

1. **Lưu phiếu khám:**
    - Status = 'completed'
    - Lưu tất cả thông tin vào medical_records
    - Lưu đơn thuốc vào prescriptions

2. **Cập nhật appointment:**
    - Status = 'completed'
    - Completed_at = timestamp hiện tại
    - Link với medical_record_id

3. **Tạo follow-up nếu cần:**
    - Nếu có ngày tái khám
    - Tự động tạo appointment mới
    - Status = 'scheduled'
    - Gửi thông báo cho bệnh nhân

4. **Gửi thông báo:**
    - Email tóm tắt kết quả khám cho BN
    - Link tải phiếu khám và đơn thuốc PDF
    - Hướng dẫn sử dụng thuốc

5. **Cập nhật thống kê:**
    - Tăng số lượt khám của bác sĩ
    - Cập nhật lịch sử khám của BN
    - Ghi log hoạt động

### 4.5. Module Tra cứu và Báo cáo

#### 4.5.1. Tra cứu lịch sử khám bệnh

**Giao diện tra cứu:**

```
┌─────────────────────────────────────────────────────────┐
│ TRA CỨU LỊCH SỬ KHÁM BỆNH                              │
├─────────────────────────────────────────────────────────┤
│ Tìm kiếm bệnh nhân:                                    │
│ [Mã BN / Họ tên / SĐT...                    ] [🔍]    │
│                                                         │
│ Lọc nâng cao:                                          │
│ Từ ngày: [DD/MM/YYYY]  Đến ngày: [DD/MM/YYYY]        │
│ Bác sĩ: [Tất cả ▼]                                    │
│ Chẩn đoán: [_______________________]                  │
├─────────────────────────────────────────────────────────┤
│ KẾT QUẢ TÌM KIẾM (156 phiếu khám)                      │
├──────┬──────────┬─────────┬──────────────┬────────────┤
│ Ngày │ Bệnh nhân│ Bác sĩ  │ Chẩn đoán    │ Thao tác   │
├──────┼──────────┼─────────┼──────────────┼────────────┤
│18/12 │Nguyễn A  │BS.Nguyễn│Viêm họng cấp │[Xem chi tiết]│
│      │BN-000123 │Văn C    │              │[In phiếu]  │
├──────┼──────────┼─────────┼──────────────┼────────────┤
│15/11 │Nguyễn A  │BS.Trần  │Cảm cúm       │[Xem chi tiết]│
│      │BN-000123 │Thị D    │              │[In phiếu]  │
├──────┴──────────┴─────────┴──────────────┴────────────┤
│ [← Trước] [1] [2] [3] ... [16] [Sau →]                │
└─────────────────────────────────────────────────────────┘
```

**Xem chi tiết phiếu khám:**

```
┌─────────────────────────────────────────────────────────┐
│ PHIẾU KHÁM BỆNH                                        │
│ Mã phiếu: MR-20241218-001                              │
├─────────────────────────────────────────────────────────┤
│ 👤 THÔNG TIN BỆNH NHÂN                                 │
│ Họ tên: Nguyễn Văn A                                   │
│ Mã BN: BN-000123                                       │
│ Ngày sinh: 15/03/1985 (39 tuổi)                       │
│ Giới tính: Nam                                          │
│ Điện thoại: 0901234567                                 │
│                                                         │
│ 👨‍⚕️ THÔNG TIN KHÁM                                    │
│ Bác sĩ: BS. Nguyễn Văn C                               │
│ Chuyên khoa: Nội tổng quát                             │
│ Ngày khám: 18/12/2024 lúc 09:00                       │
│                                                         │
│ 📊 SINH HIỆU                                           │
│ Cân nặng: 70 kg        Chiều cao: 170 cm              │
│ Nhiệt độ: 38.5°C                                       │
│ Huyết áp: 120/80 mmHg  Nhịp tim: 80 bpm               │
│ Nhịp thở: 18 lần/phút                                  │
│                                                         │
│ 🏥 THÔNG TIN LÂM SÀNG                                  │
│ Lý do khám: Đau họng, ho, sốt 2 ngày                  │
│                                                         │
│ Triệu chứng:                                           │
│ - Đau họng khi nuốt                                    │
│ - Ho khan, không có đờm                                │
│ - Sốt nhẹ 38-38.5°C                                    │
│ - Người mệt mỏi, ăn kém                                │
│                                                         │
│ 🔬 CHẨN ĐOÁN                                           │
│ Viêm họng cấp                                          │
│                                                         │
│ Chi tiết chẩn đoán:                                    │
│ - Niêm mạc họng đỏ, sưng                              │
│ - Amidan phì đại độ II                                 │
│ - Hạch cổ sưng nhẹ                                     │
│ - Không có triệu chứng biến chứng                      │
│                                                         │
│ 💊 ĐƠN THUỐC                                           │
│ 1. Paracetamol 500mg                                   │
│    Liều: 1 viên x 3 lần/ngày x 7 ngày (21 viên)      │
│    Cách dùng: Sau ăn 30 phút                          │
│                                                         │
│ 2. Viên ngậm Strepsils                                 │
│    Liều: 1 viên x 4-5 lần/ngày x 5 ngày (25 viên)    │
│    Cách dùng: Ngậm từ từ, không nhai                  │
│                                                         │
│ 📝 KẾ HOẠCH ĐIỀU TRỊ                                   │
│ - Nghỉ ngơi đầy đủ                                     │
│ - Uống nhiều nước ấm                                   │
│ - Ăn đồ mềm, dễ nuốt                                   │
│ - Tái khám sau 7 ngày nếu không đỡ                     │
│                                                         │
│ [In phiếu khám] [In đơn thuốc] [Đặt lịch tái khám]    │
└─────────────────────────────────────────────────────────┘
```

#### 4.5.2. Báo cáo và Thống kê

**Dashboard thống kê (Admin):**

```
┌─────────────────────────────────────────────────────────┐
│ DASHBOARD THỐNG KÊ                                     │
│ Khoảng thời gian: [Tháng này ▼]                       │
├─────────────────────────────────────────────────────────┤
│ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐   │
│ │ 📅 Lịch hẹn │ │ 👥 Bệnh nhân│ │ 💰 Doanh thu│   │
│ │     245      │ │     189     │ │  48,5tr VNĐ │   │
│ │   ↑ 12%     │ │   ↑ 8%     │ │   ↑ 15%    │   │
│ └──────────────┘ └──────────────┘ └──────────────┘   │
│ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐   │
│ │ ⭐ Đánh giá │ │ 📋 Phiếu khám│ │ 🏥 Bác sĩ   │   │
│ │    4.8/5     │ │     215     │ │      8      │   │
│ │   ↑ 0.2     │ │   ↑ 10%    │ │   ↔         │   │
│ └──────────────┘ └──────────────┘ └──────────────┘   │
├─────────────────────────────────────────────────────────┤
│ BIỂU ĐỒ LỊCH HẸN THEO NGÀY                            │
│ ┌─────────────────────────────────────────────────────┐│
│ │    │                                 ╭─╮           ││
│ │ 40 │                     ╭─╮     ╭─╮│ │           ││
│ │    │         ╭─╮     ╭─╮│ │ ╭─╮│ ││ │           ││
│ │ 30 │     ╭─╮│ │ ╭─╮│ ││ │ │ ││ ││ │           ││
│ │    │ ╭─╮│ ││ │ │ ││ ││ │ │ ││ ││ │           ││
│ │ 20 │ │ ││ ││ │ │ ││ ││ │ │ ││ ││ │           ││
│ │    ├─┴─┴┴─┴┴─┴─┴─┴┴─┴┴─┴─┴─┴┴─┴┴─┴─┴───────────┤│
│ │    T2 T3 T4 T5 T6 T7 CN T2 T3 T4 T5 T6 T7 CN   ││
│ └─────────────────────────────────────────────────────┘│
├─────────────────────────────────────────────────────────┤
│ THỐNG KÊ THEO CHUYÊN KHOA                              │
│ ┌─────────────────────────────────────────────────────┐│
│ │ Nội tổng quát    ████████████░░░░ 85 lượt (35%)   ││
│ │ Nhi khoa         ██████████░░░░░░ 62 lượt (25%)   ││
│ │ Da liễu          ████████░░░░░░░░ 48 lượt (20%)   ││
│ │ Tim mạch         ██████░░░░░░░░░░ 35 lượt (14%)   ││
│ │ Khác             ██░░░░░░░░░░░░░░ 15 lượt (6%)    ││
│ └─────────────────────────────────────────────────────┘│
├─────────────────────────────────────────────────────────┤
│ TOP BÁC SĨ THEO SỐ LƯỢT KHÁM                           │
│ ┌─────────────────────────────────────────────────────┐│
│ │ 1. BS. Nguyễn Văn C    85 lượt  ⭐ 4.9            ││
│ │ 2. BS. Trần Thị D      72 lượt  ⭐ 4.8            ││
│ │ 3. BS. Lê Văn E        58 lượt  ⭐ 4.7            ││
│ │ 4. BS. Phạm Thị F      45 lượt  ⭐ 4.6            ││
│ └─────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────┘
```

**Các loại báo cáo:**

1. **Báo cáo danh sách bệnh nhân:**
    - Lọc theo: Ngày đăng ký, Giới tính, Độ tuổi
    - Xuất: Excel, PDF
    - Nội dung: Mã BN, Họ tên, Ngày sinh, SĐT, Địa chỉ

2. **Báo cáo lịch hẹn:**
    - Lọc theo: Ngày, Bác sĩ, Trạng thái
    - Xuất: Excel, PDF
    - Nội dung: Mã hẹn, BN, Bác sĩ, Ngày giờ, Trạng thái

3. **Báo cáo phiếu khám:**
    - Lọc theo: Ngày khám, Bác sĩ, Chẩn đoán
    - Xuất: Excel, PDF
    - Nội dung: Mã phiếu, BN, Bác sĩ, Chẩn đoán, Điều trị

4. **Báo cáo thống kê tổng hợp:**
    - Theo tháng/quý/năm
    - Số lượt khám theo chuyên khoa
    - Số lượt khám theo bác sĩ
    - Tỷ lệ hẹn/hoàn thành/hủy
    - Bệnh thường gặp

5. **Báo cáo hiệu suất bác sĩ:**
    - Số lượt khám
    - Thời gian khám trung bình
    - Đánh giá từ bệnh nhân
    - Tỷ lệ tái khám

### 4.6. Module Quản lý Người dùng

#### 4.6.1. Phân quyền hệ thống

**Vai trò và quyền hạn:**

**1. Admin:**
- Quản lý toàn bộ hệ thống
- Quản lý users (CRUD)
- Quản lý bác sĩ, bệnh nhân
- Xem tất cả báo cáo
- Cấu hình hệ thống
- Xem logs hoạt động

**2. Doctor:**
- Xem lịch hẹn của mình
- Khám bệnh, kê đơn
- Xem hồ sơ bệnh nhân (đã khám)
- Cập nhật lịch làm việc
- Xem báo cáo cá nhân

**3. Receptionist:**
- Đăng ký bệnh nhân mới
- Đặt/Hủy/Đổi lịch hẹn
- Xác nhận lịch hẹn
- Xem danh sách bệnh nhân
- In phiếu hẹn

**4. Patient:**
- Xem hồ sơ cá nhân
- Đặt lịch khám
- Xem lịch sử khám
- Xem đơn thuốc
- Đánh giá dịch vụ

#### 4.6.2. Quản lý tài khoản

**Danh sách users:**
```
┌─────────────────────────────────────────────────────────┐
│ QUẢN LÝ NGƯỜI DÙNG                                     │
├─────────────────────────────────────────────────────────┤
│ [Tìm kiếm...] [Lọc: Tất cả ▼] [+ Thêm user mới]       │
├────┬───────────┬───────────────┬────────┬──────────────┤
│ ID │ Họ tên    │ Email         │ Vai trò│ Trạng thái   │
├────┼───────────┼───────────────┼────────┼──────────────┤
│ 1  │Admin User │admin@phong... │Admin   │🟢 Active     │
│ 2  │BS.Nguyễn C│doctor1@...    │Doctor  │🟢 Active     │
│ 3  │Lễ tân A   │receptionist@..│Recept..│🟢 Active     │
│ 4  │Nguyễn A   │patient1@...   │Patient │🟢 Active     │
├────┴───────────┴───────────────┴────────┴──────────────┤
│ [← Trước] [1] [2] [3] [Sau →]                         │
└─────────────────────────────────────────────────────────┘
```

## 5. TÍNH NĂNG BỔ SUNG

### 5.1. Hệ thống thông báo (Notifications)

**Các loại thông báo:**

1. **Nhắc lịch hẹn:**
    - Gửi trước 24h
    - Gửi trước 2h
    - Kênh: Email, SMS, In-app

2. **Thông báo đặt lịch thành công:**
    - Xác nhận đặt lịch
    - Thông tin chi tiết
    - Hướng dẫn chuẩn bị

3. **Thông báo hủy/đổi lịch:**
    - Lý do hủy/đổi
    - Đề xuất lịch mới

4. **Thông báo kết quả khám:**
    - Tóm tắt chẩn đoán
    - Link tải phiếu khám
    - Hướng dẫn điều trị

5. **Thông báo tái khám:**
    - Nhắc theo lịch tái khám
    - Đề xuất đặt lịch

### 5.2. Tìm kiếm nâng cao

**Full-text search:**
- Tìm bệnh nhân: Theo mã, tên, SĐT
- Tìm phiếu khám: Theo chẩn đoán, triệu chứng
- Tìm thuốc: Theo tên, thành phần

**Filters:**
- Nhiều điều kiện kết hợp
- Lưu filter thường dùng
- Export kết quả tìm kiếm

### 5.3. Xuất báo cáo

**Định dạng hỗ trợ:**
- PDF: Phiếu khám, Đơn thuốc, Báo cáo
- Excel: Danh sách, Thống kê
- Print-friendly: In trực tiếp

**Template báo cáo:**
- Logo phòng khám
- Header/Footer tùy chỉnh
- Chữ ký điện tử bác sĩ

### 5.4. Audit Log

**Ghi nhận:**
- Ai làm gì, khi nào
- Thay đổi dữ liệu quan trọng
- Đăng nhập/Đăng xuất
- Truy cập hồ sơ bệnh nhân

**Bảo mật:**
- Encrypt dữ liệu nhạy cảm
- Backup tự động
- Retention policy (lưu trữ 5 năm)

## 6. YÊU CẦU PHI CHỨC NĂNG

### 6.1. Hiệu năng (Performance)

**Thời gian phản hồi:**
- Trang thông thường: < 2 giây
- Tìm kiếm: < 1 giây
- Xuất báo cáo: < 5 giây
- Upload file: < 3 giây

**Tối ưu hóa:**
- Database indexing cho các truy vấn thường dùng
- Query optimization với Eloquent
- Lazy loading cho dữ liệu lớn
- Cache cho dữ liệu ít thay đổi (danh mục, bác sĩ)
- CDN cho static assets
- Image optimization (resize, compress)

**Khả năng mở rộng:**
- Hỗ trợ 100+ concurrent users
- Lưu trữ 10,000+ bệnh nhân
- 50,000+ phiếu khám/năm

### 6.2. Bảo mật (Security)

**Authentication:**
- Laravel Breeze/Sanctum
- Password hashing (bcrypt)
- Two-factor authentication (Optional)
- Session timeout: 30 phút không hoạt động

**Authorization:**
- Role-based access control (RBAC)
- Permission-based cho từng chức năng
- Policy classes cho Eloquent models

**Data Security:**
- HTTPS bắt buộc
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- CSRF protection (Laravel token)
- Input validation & sanitization
- Encrypt dữ liệu nhạy cảm (hồ sơ y tế)

**HIPAA/Privacy Compliance:**
- Mã hóa dữ liệu bệnh nhân
- Audit trail cho truy cập hồ sơ
- Right to be forgotten
- Data anonymization cho báo cáo
- Secure file storage

**Backup & Recovery:**
- Backup database hàng ngày
- Backup file hàng tuần
- Disaster recovery plan
- RTO: < 4 giờ
- RPO: < 24 giờ

### 6.3. Tính khả dụng (Availability)

**Uptime:**
- Target: 99.5% (≈ 43 giờ downtime/năm)
- Maintenance window: 2-6 AM chủ nhật

**Monitoring:**
- Server health monitoring
- Database performance monitoring
- Error tracking & alerting
- Log aggregation

**High Availability (Optional):**
- Load balancer
- Database replication
- Failover mechanism

### 6.4. Khả năng sử dụng (Usability)

**Giao diện:**
- Responsive design (desktop, tablet, mobile)
- Intuitive navigation
- Consistent UI/UX
- Accessibility (WCAG 2.1 Level AA)

**User Experience:**
- Minimal clicks to complete tasks
- Inline validation & helpful error messages
- Auto-save drafts
- Keyboard shortcuts cho power users
- Loading indicators
- Success/Error notifications

**Documentation:**
- User manual
- Video tutorials
- In-app help & tooltips
- FAQ section

### 6.5. Tính tương thích (Compatibility)

**Browsers:**
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

**Devices:**
- Desktop: Windows, macOS, Linux
- Tablet: iPad, Android tablets
- Mobile: iOS, Android (responsive web)

**Database:**
- MySQL 8.0+
- MariaDB 10.5+

**Server:**
- PHP 8.1+
- Nginx/Apache
- Linux (Ubuntu 20.04+/CentOS 8+)

### 6.6. Bảo trì (Maintainability)

**Code Quality:**
- Follow PSR-12 coding standards
- Use Laravel best practices
- Comment for complex logic
- Unit tests coverage > 70%
- Feature tests for critical flows

**Version Control:**
- Git workflow (GitFlow)
- Meaningful commit messages
- Pull request reviews
- Semantic versioning

**Documentation:**
- API documentation
- Database schema documentation
- Deployment guide
- Architecture decision records (ADRs)

**Logging:**
- Application logs (Laravel Log)
- Error logs with stack traces
- Audit logs for critical operations
- Log rotation & archival

## 7. LUỒNG NGHIỆP VỤ CHI TIẾT

### 7.1. Luồng đặt lịch hẹn

```
[Bắt đầu]
    ↓
[Người dùng đăng nhập/Không đăng nhập]
    ↓
[Chọn chuyên khoa]
    ↓
[Hiển thị danh sách bác sĩ phù hợp]
    ↓
[Chọn bác sĩ]
    ↓
[Load lịch làm việc của bác sĩ]
    ↓
[Hiển thị lịch với các slot trống]
    ↓
[Chọn ngày]
    ↓
[Chọn khung giờ]
    ↓
[Kiểm tra slot còn trống?]
    ├─ Không → [Thông báo "Đã được đặt"] → [Quay lại chọn slot khác]
    └─ Có → [Tiếp tục]
         ↓
    [Nhập thông tin: Lý do khám, Ghi chú]
         ↓
    [Xác nhận thông tin]
         ↓
    [BEGIN TRANSACTION]
         ↓
    [Kiểm tra lại slot (Lock for update)]
         ↓
    [Tạo Appointment]
         ├─ patient_id
         ├─ doctor_id
         ├─ date, time
         ├─ status = 'scheduled'
         └─ appointment_number (auto-generate)
         ↓
    [COMMIT TRANSACTION]
         ↓
    [Gửi email xác nhận cho bệnh nhân]
         ↓
    [Gửi thông báo cho bác sĩ]
         ↓
    [Tạo reminder job (nhắc trước 24h, 2h)]
         ↓
    [Hiển thị thông báo thành công]
         ↓
    [Hiển thị mã hẹn & hướng dẫn]
         ↓
[Kết thúc]
```

### 7.2. Luồng khám bệnh

```
[Bắt đầu]
    ↓
[Bệnh nhân đến phòng khám]
    ↓
[Lễ tân check-in]
    ├─ Có hẹn → [Tìm appointment] → [Cập nhật status = 'confirmed']
    └─ Không hẹn → [Đăng ký khám mới] → [Tạo appointment mới]
         ↓
[Bệnh nhân chờ đợi]
    ↓
[Bác sĩ xem danh sách lịch hẹn]
    ↓
[Bác sĩ gọi bệnh nhân]
    ↓
[Click "Bắt đầu khám"]
    ├─ Appointment status = 'in_progress'
    └─ Mở form Medical Record
         ↓
[Nhập sinh hiệu]
    ├─ Cân nặng, Chiều cao
    ├─ Nhiệt độ
    ├─ Huyết áp
    ├─ Nhịp tim
    └─ Nhịp thở
         ↓
[Load tiền sử bệnh của bệnh nhân]
    ├─ Medical history
    ├─ Allergies
    └─ Previous diagnoses
         ↓
[Khám lâm sàng]
    ├─ Ghi nhận triệu chứng
    ├─ Thăm khám
    └─ Đánh giá tình trạng
         ↓
[Chẩn đoán]
    ├─ Xác định bệnh
    ├─ Mã ICD-10 (optional)
    └─ Chi tiết chẩn đoán
         ↓
[Chỉ định (nếu cần)]
    ├─ Xét nghiệm
    ├─ Chẩn đoán hình ảnh
    └─ Chỉ định khác
         ↓
[Kê đơn thuốc]
    ↓
[Lặp cho từng thuốc]
    ├─ Chọn/Nhập tên thuốc
    ├─ Kiểm tra dị ứng (Auto)
    │   └─ Nếu phát hiện → [Cảnh báo] → [Chọn thuốc khác]
    ├─ Nhập liều dùng
    ├─ Nhập tần suất
    ├─ Nhập số ngày
    ├─ Tính số lượng (Auto)
    └─ Nhập hướng dẫn sử dụng
         ↓
[Kế hoạch điều trị]
    ├─ Chế độ ăn uống
    ├─ Chế độ sinh hoạt
    ├─ Lưu ý khác
    └─ Ngày tái khám (optional)
         ↓
[Ghi chú bổ sung]
    ↓
[Click "Hoàn thành khám"]
    ↓
[BEGIN TRANSACTION]
    ↓
[Lưu Medical Record]
    ├─ Status = 'completed'
    └─ Link với Appointment
         ↓
[Lưu các Prescriptions]
    ↓
[Cập nhật Appointment]
    ├─ Status = 'completed'
    ├─ Completed_at = now()
    └─ Link medical_record_id
         ↓
[Nếu có ngày tái khám]
    └─ Tạo Appointment mới
         ├─ Status = 'scheduled'
         └─ Gửi thông báo cho bệnh nhân
         ↓
[COMMIT TRANSACTION]
    ↓
[Gửi email tóm tắt kết quả khám]
    ├─ Chẩn đoán
    ├─ Đơn thuốc
    ├─ Hướng dẫn
    └─ Link tải phiếu khám PDF
         ↓
[In phiếu khám & đơn thuốc cho bệnh nhân]
    ↓
[Bệnh nhân rời phòng khám]
    ↓
[Kết thúc]
```

### 7.3. Luồng xử lý reminder tự động

```
[Scheduler chạy mỗi giờ]
    ↓
[Query appointments cần nhắc]
    ├─ Nhắc 24h: appointment_date = tomorrow
    │            AND status = 'confirmed'
    │            AND reminder_sent_at IS NULL
    └─ Nhắc 2h:  appointment_date = today
                 AND appointment_time IN next 2 hours
                 AND status = 'confirmed'
                 AND reminder_sent_at IS NOT NULL (đã nhắc 24h)
    ↓
[Lặp qua từng appointment]
    ↓
[Lấy thông tin bệnh nhân & bác sĩ]
    ↓
[Chuẩn bị nội dung nhắc lịch]
    ├─ Họ tên bệnh nhân
    ├─ Ngày giờ khám
    ├─ Bác sĩ
    ├─ Địa điểm
    └─ Lưu ý chuẩn bị
    ↓
[Gửi qua các kênh]
    ├─ Email
    │   └─ Queue job: SendReminderEmail
    ├─ SMS (optional)
    │   └─ Queue job: SendReminderSMS
    └─ In-app Notification
        └─ Tạo record trong bảng notifications
    ↓
[Cập nhật appointment]
    └─ reminder_sent_at = now()
         ↓
[Log reminder đã gửi]
    ↓
[Tiếp tục với appointment tiếp theo]
    ↓
[Kết thúc]
```

## 8. KỊCH BẢN KIỂM THỬ

### 8.1. Test Cases chính

#### TC-001: Đăng ký bệnh nhân mới

**Preconditions:** User có quyền receptionist/admin đã đăng nhập

**Steps:**
1. Vào menu "Bệnh nhân" → "Thêm mới"
2. Nhập đầy đủ thông tin bắt buộc
3. Click "Lưu"

**Expected Result:**
- Bệnh nhân được tạo với mã BN tự động
- Email xác nhận được gửi (nếu có email)
- Chuyển đến trang chi tiết bệnh nhân
- Thông báo "Tạo bệnh nhân thành công"

**Test Data:**
```
Họ tên: Nguyễn Văn Test
Email: test@example.com
SĐT: 0901234567
Ngày sinh: 01/01/1990
Giới tính: Nam
```

#### TC-002: Đặt lịch hẹn

**Preconditions:**
- Bệnh nhân đã tồn tại trong hệ thống
- Bác sĩ có lịch làm việc

**Steps:**
1. Vào "Lịch hẹn" → "Đặt lịch mới"
2. Chọn bệnh nhân
3. Chọn chuyên khoa
4. Chọn bác sĩ
5. Chọn ngày và giờ trống
6. Nhập lý do khám
7. Click "Xác nhận đặt lịch"

**Expected Result:**
- Appointment được tạo với mã APT-YYYYMMDD-XXX
- Email xác nhận gửi cho bệnh nhân
- Thông báo gửi cho bác sĩ
- Reminder jobs được tạo
- Slot thời gian được đánh dấu "Đã đặt"

#### TC-003: Khám bệnh và kê đơn

**Preconditions:**
- Có appointment với status = 'confirmed'
- Bác sĩ đã đăng nhập

**Steps:**
1. Bác sĩ vào "Lịch hẹn của tôi"
2. Click "Bắt đầu khám" trên appointment
3. Nhập sinh hiệu
4. Nhập triệu chứng, chẩn đoán
5. Click "Kê đơn thuốc"
6. Thêm 2 loại thuốc
7. Click "Hoàn thành khám"

**Expected Result:**
- Medical record được tạo
- Prescriptions được lưu (2 records)
- Appointment status = 'completed'
- Email tóm tắt gửi cho bệnh nhân
- Phiếu khám có thể in PDF

#### TC-004: Tìm kiếm bệnh nhân

**Preconditions:** Có ít nhất 10 bệnh nhân trong hệ thống

**Steps:**
1. Vào "Bệnh nhân"
2. Nhập "Nguyễn" vào ô tìm kiếm
3. Bấm Enter hoặc click icon tìm kiếm

**Expected Result:**
- Hiển thị danh sách bệnh nhân có họ "Nguyễn"
- Highlight từ khóa trong kết quả
- Số lượng kết quả hiển thị
- Có thể sort, filter kết quả

### 8.2. Test Cases nâng cao

#### TC-005: Xử lý đặt lịch trùng (Concurrency)

**Scenario:** 2 lễ tân cùng lúc đặt lịch cho 1 slot

**Steps:**
1. User A chọn BS. Nguyễn, 18/12/2024, 09:00
2. User B chọn BS. Nguyễn, 18/12/2024, 09:00
3. User A click "Xác nhận" trước 1 giây
4. User B click "Xác nhận"

**Expected Result:**
- User A: Đặt lịch thành công
- User B: Thông báo "Khung giờ đã được đặt. Vui lòng chọn giờ khác"
- Database chỉ có 1 appointment cho slot đó

#### TC-006: Kiểm tra cảnh báo dị ứng thuốc

**Preconditions:** Bệnh nhân có dị ứng Penicillin

**Steps:**
1. Bác sĩ kê đơn thuốc cho bệnh nhân
2. Chọn thuốc "Amoxicillin" (nhóm Penicillin)
3. Nhập liều lượng

**Expected Result:**
- Hiển thị cảnh báo màu đỏ: "⚠️ Bệnh nhân dị ứng với Penicillin"
- Gợi ý thuốc thay thế
- Yêu cầu xác nhận trước khi lưu

#### TC-007: Validation dữ liệu sinh hiệu

**Steps:**
1. Nhập nhiệt độ = 50°C
2. Nhập huyết áp tâm thu = 300 mmHg
3. Nhập nhịp tim = 10 bpm
4. Click "Lưu"

**Expected Result:**
- Hiển thị lỗi validation:
    - "Nhiệt độ không hợp lý (35-42°C)"
    - "Huyết áp tâm thu quá cao (80-200 mmHg)"
    - "Nhịp tim quá thấp (40-200 bpm)"
- Form không được submit
- Focus vào field lỗi đầu tiên

### 8.3. Security Testing

#### ST-001: SQL Injection

**Steps:**
1. Trong ô tìm kiếm bệnh nhân, nhập: `'; DROP TABLE patients; --`
2. Click tìm kiếm

**Expected Result:**
- Không xảy ra SQL injection
- Tìm kiếm bình thường (0 kết quả hoặc escaped string)
- Bảng patients vẫn tồn tại

#### ST-002: XSS Attack

**Steps:**
1. Trong form ghi chú, nhập: `<script>alert('XSS')</script>`
2. Lưu và hiển thị lại ghi chú

**Expected Result:**
- Script không được thực thi
- Hiển thị dưới dạng text: `&lt;script&gt;alert('XSS')&lt;/script&gt;`

#### ST-003: Unauthorized Access

**Steps:**
1. Đăng nhập với role Patient
2. Truy cập trực tiếp URL: `/admin/doctors`

**Expected Result:**
- Bị chặn truy cập
- Redirect về trang 403 hoặc dashboard
- Thông báo "Bạn không có quyền truy cập"

### 8.4. Performance Testing

#### PT-001: Load Testing

**Scenario:** 50 users đồng thời đặt lịch hẹn

**Metrics:**
- Response time < 3s cho 95% requests
- Error rate < 1%
- Server CPU < 80%
- Database connections < 100

#### PT-002: Stress Testing

**Scenario:** Tăng dần số users từ 10 → 100

**Expected Result:**
- Xác định breaking point
- Hệ thống graceful degradation
- Không bị crash

## 9. TRIỂN KHAI VÀ BẢO TRÌ

### 9.1. Môi trường triển khai

**Development:**
- Local environment
- Database: MySQL local
- Debug mode ON
- Test data

**Staging:**
- Server giống Production
- Database: Clone từ Production
- Debug mode ON
- UAT testing

**Production:**
- VPS/Cloud server
- Database: MySQL với replication
- Debug mode OFF
- Real data

### 9.2. Quy trình triển khai

**Deployment Steps:**

1. **Pre-deployment:**
    - Code review đã pass
    - Tests đã pass (Unit + Feature)
    - Backup database Production
    - Thông báo downtime (nếu có)

2. **Deployment:**
    - Pull code từ repository
    - Run `composer install --no-dev`
    - Run `npm run build`
    - Run `php artisan migrate --force`
    - Run `php artisan config:cache`
    - Run `php artisan route:cache`
    - Run `php artisan view:cache`
    - Restart queue workers
    - Clear application cache

3. **Post-deployment:**
    - Smoke testing các chức năng chính
    - Monitor logs & errors
    - Verify database migrations
    - Check scheduled tasks
    - Rollback nếu có vấn đề

### 9.3. Backup Strategy

**Database Backup:**
- Frequency: Hàng ngày lúc 2 AM
- Retention: 30 ngày
- Method: mysqldump hoặc snapshot
- Storage: Local + Cloud (S3/Google Cloud)

**File Backup:**
- Frequency: Hàng tuần
- Include: Uploaded files, documents
- Retention: 60 ngày

**Application Code:**
- Version control: Git repository
- Tags cho mỗi release
- Backup repository

### 9.4. Monitoring & Maintenance

**Daily:**
- Check error logs
- Monitor server resources
- Verify scheduled tasks ran
- Check backup success

**Weekly:**
- Review performance metrics
- Update dependencies (security patches)
- Database optimization
- Clear old logs

**Monthly:**
- Security audit
- Performance review
- User feedback review
- Feature planning

**Quarterly:**
- Full backup test (restore & verify)
- Disaster recovery drill
- Capacity planning
- Code refactoring

## 10. ROADMAP VÀ MỞ RỘNG

### 10.1. Phase 1 - MVP (Tháng 1-2)

**Core Features:**
- ✅ Quản lý bệnh nhân (CRUD)
- ✅ Quản lý bác sĩ (CRUD)
- ✅ Đặt lịch hẹn cơ bản
- ✅ Phiếu khám bệnh
- ✅ Kê đơn thuốc
- ✅ Tra cứu lịch sử khám
- ✅ Báo cáo cơ bản

### 10.2. Phase 2 - Enhancement (Tháng 3-4)

**Additional Features:**
- 📧 Email notifications
- 📊 Dashboard analytics
- 📄 Export PDF/Excel
- 🔔 Reminder system
- 📱 Responsive design
- 🔍 Advanced search

### 10.3. Phase 3 - Advanced (Tháng 5-6)

**Advanced Features:**
- 💬 SMS notifications (Twilio)
- 📅 Patient self-booking portal
- ⭐ Rating & reviews
- 📊 Advanced analytics
- 🏥 Multi-clinic support
- 🌐 Multi-language

### 10.4. Phase 4 - Integration (Tháng 7+)

**Future Integrations:**
- 💳 Payment gateway
- 🏦 BHYT integration
- 🔬 Lab system integration
- 📷 Medical imaging (PACS)
- 💊 Pharmacy management
- 📱 Mobile app (Flutter)
- 🎥 Telemedicine
- 🤖 AI diagnosis assistance

---

## PHỤ LỤC

### A. Thuật ngữ viết tắt

- **CRUD**: Create, Read, Update, Delete
- **API**: Application Programming Interface
- **PDF**: Portable Document Format
- **SMS**: Short Message Service
- **UI/UX**: User Interface/User Experience
- **MVC**: Model-View-Controller
- **ORM**: Object-Relational Mapping
- **RBAC**: Role-Based Access Control
- **HTTPS**: HyperText Transfer Protocol Secure
- **CSRF**: Cross-Site Request Forgery
- **XSS**: Cross-Site Scripting
- **SQL**: Structured Query Language
- **TTL**: Time To Live
- **RTO**: Recovery Time Objective
- **RPO**: Recovery Point Objective

### B. Tài liệu tham khảo

1. Laravel Documentation: https://laravel.com/docs
2. Filament Documentation: https://filamentphp.com/docs
3. MySQL Documentation: https://dev.mysql.com/doc/
4. HIPAA Compliance Guide
5. Healthcare Software Best Practices

### C. Liên hệ & Hỗ trợ

**Technical Support:**
- Email: support@phongkham.com
- Phone: 1900-xxxx
- Hours: 8 AM - 6 PM (T2-T6)

**Development Team:**
- Project Manager: [Tên]
- Lead Developer: [Tên]
- Backend Developer: [Tên]
- Frontend Developer: [Tên]
- QA Engineer: [Tên]

---

**Document Version:** 1.0
**Last Updated:** [Ngày tháng năm]
**Status:** Draft/Final
**Approved By:** [Tên người phê duyệt]# PHÂN TÍCH THIẾT KẾ HỆ THỐNG WEBSITE QUẢN LÝ PHÒNG KHÁM

## 1. TỔNG QUAN DỰ ÁN

### 1.1. Giới thiệu
Hệ thống website quản lý hoạt động khám bệnh tại phòng khám tư nhân, cung cấp nền tảng số hóa toàn diện cho việc quản lý bệnh nhân, lịch khám, chẩn đoán và báo cáo. Hệ thống giúp tối ưu hóa quy trình làm việc, giảm thiểu sai sót và nâng cao chất lượng dịch vụ y tế.

### 1.2. Mục tiêu hệ thống
- Số hóa quy trình quản lý khám bệnh từ đầu đến cuối
- Hỗ trợ đặt lịch và điều phối lịch khám hiệu quả
- Lưu trữ và tra cứu hồ sơ bệnh án điện tử
- Quản lý chẩn đoán, chỉ định và kê đơn thuốc
- Tạo báo cáo thống kê và phân tích dữ liệu
- Tối ưu trải nghiệm người dùng trên mọi thiết bị
- Đảm bảo bảo mật thông tin y tế

### 1.3. Phạm vi hệ thống

**Bao gồm:**
- Quản lý hồ sơ bệnh nhân (demographics, tiền sử bệnh)
- Quản lý thông tin bác sĩ và lịch làm việc
- Đặt lịch khám và điều phối lịch hẹn
- Nhắc lịch tự động qua email/SMS
- Ghi nhận phiếu khám bệnh (triệu chứng, chẩn đoán, chỉ định)
- Kê đơn thuốc điện tử
- Tra cứu lịch sử khám chữa bệnh
- Xuất báo cáo và thống kê
- Quản lý người dùng và phân quyền

**Không bao gồm:**
- Quản lý kho thuốc và vật tư y tế
- Quản lý tài chính và kế toán
- Tích hợp thiết bị y tế (máy xét nghiệm, chụp X-quang...)
- Hệ thống thanh toán trực tuyến
- Quản lý nhân sự và chấm công
- Telemedicine (khám bệnh từ xa)

### 1.4. Công nghệ sử dụng

#### Backend
- **Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL 8.0+
- **ORM**: Eloquent
- **Authentication**: Laravel Breeze/Sanctum

#### Admin Panel
- **Admin Framework**: Filament 3.x
- **UI Components**: Filament Form Builder, Table Builder
- **Charts**: Filament Charts (powered by Chart.js)

#### Frontend (Patient Portal - Optional)
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js, Livewire
- **Icons**: Heroicons

#### Storage & Utilities
- **File Storage**: Local Storage / AWS S3
- **PDF Generation**: DomPDF / Snappy (wkhtmltopdf)
- **Excel Export**: Maatwebsite/Laravel-Excel
- **Email**: SMTP (Gmail, Mailgun)
- **SMS**: Twilio / Vonage (Optional)

#### Công cụ khác
- **Version Control**: Git
- **Package Manager**: Composer (PHP), NPM (JS)
- **Queue**: Redis / Database Queue
- **Task Scheduling**: Laravel Scheduler

## 2. KIẾN TRÚC HỆ THỐNG

### 2.1. Kiến trúc tổng thể (High-Level Architecture)

```
┌────────────────────────────────────────────────────────┐
│                    CLIENT LAYER                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │   Admin      │  │   Doctor     │  │   Patient    │ │
│  │   Portal     │  │   Portal     │  │   Portal     │ │
│  │ (Filament)   │  │ (Filament)   │  │   (Blade)    │ │
│  └──────────────┘  └──────────────┘  └──────────────┘ │
└────────────────────────────────────────────────────────┘
                         ↓ HTTPS
┌────────────────────────────────────────────────────────┐
│               WEB SERVER (Nginx/Apache)                │
└────────────────────────────────────────────────────────┘
                         ↓
┌────────────────────────────────────────────────────────┐
│              APPLICATION LAYER (Laravel)               │
│  ┌──────────────────────────────────────────────────┐ │
│  │              Routes & Middleware                 │ │
│  │  • Web Routes    • API Routes                    │ │
│  │  • Auth          • Role & Permission             │ │
│  └──────────────────────────────────────────────────┘ │
│  ┌──────────────────────────────────────────────────┐ │
│  │              Filament Resources                  │ │
│  │  • PatientResource    • AppointmentResource      │ │
│  │  • DoctorResource     • MedicalRecordResource    │ │
│  └──────────────────────────────────────────────────┘ │
│  ┌──────────────────────────────────────────────────┐ │
│  │              Business Logic Layer                │ │
│  │  • Services      • Repositories                  │ │
│  │  • Actions       • Helpers                       │ │
│  └──────────────────────────────────────────────────┘ │
│  ┌──────────────────────────────────────────────────┐ │
│  │              Models (Eloquent)                   │ │
│  └──────────────────────────────────────────────────┘ │
└────────────────────────────────────────────────────────┘
                         ↓
┌────────────────────────────────────────────────────────┐
│                DATA LAYER (MySQL)                      │
│  • Patients     • Appointments    • Medical Records   │
│  • Doctors      • Prescriptions   • Reports           │
└────────────────────────────────────────────────────────┘
                         ↓
                ┌────────┴────────┐
                ↓                 ↓
    ┌─────────────────┐  ┌─────────────────┐
    │  File Storage   │  │  Queue System   │
    │  (Documents)    │  │  (Jobs, Emails) │
    └─────────────────┘  └─────────────────┘
```

### 2.2. Kiến trúc phân lớp (Layered Architecture)

#### 2.2.1. Presentation Layer (Lớp giao diện)
**Chức năng:**
- Hiển thị giao diện quản trị (Filament Admin Panel)
- Hiển thị giao diện bệnh nhân (Optional Patient Portal)
- Xử lý input từ người dùng
- Render components và forms

**Thành phần:**
- Filament Resources (Tables, Forms, Actions)
- Filament Widgets (Charts, Stats)
- Blade Templates (Patient Portal)
- Livewire Components (Real-time features)

**Trách nhiệm:**
- Không chứa business logic
- Validation cơ bản phía client
- Hiển thị dữ liệu từ Service Layer

#### 2.2.2. Application Layer (Lớp ứng dụng)
**Chức năng:**
- Điều phối luồng xử lý
- Xử lý HTTP Request/Response
- Authorization và Authentication

**Thành phần:**
- Filament Resources
- Controllers (cho API/Patient Portal)
- Middleware (Auth, Role-based Access)
- Form Requests
- Policies

**Trách nhiệm:**
- Nhận request từ user
- Gọi Service xử lý
- Trả về response/view

#### 2.2.3. Business Logic Layer (Lớp nghiệp vụ)
**Chức năng:**
- Chứa logic nghiệp vụ chính
- Xử lý các quy tắc y tế và phòng khám
- Tính toán, xử lý dữ liệu phức tạp

**Thành phần:**
- Services (AppointmentService, MedicalRecordService...)
- Actions (Filament Actions)
- Business Rules Validators
- Helper Classes

**Trách nhiệm:**
- Kiểm tra trùng lịch hẹn
- Validate nghiệp vụ y tế
- Xử lý logic đặt lịch, kê đơn
- Tính toán báo cáo thống kê

#### 2.2.4. Data Access Layer (Lớp truy cập dữ liệu)
**Chức năng:**
- Tương tác với database
- CRUD operations
- Query optimization

**Thành phần:**
- Models (Eloquent)
- Repositories (optional)
- Database Migrations
- Seeders

**Trách nhiệm:**
- Truy vấn database
- Relationships giữa các bảng
- Caching dữ liệu

#### 2.2.5. Infrastructure Layer (Lớp hạ tầng)
**Chức năng:**
- Xử lý storage
- Email, SMS notifications
- File processing

**Thành phần:**
- File Storage
- Mail Service
- PDF Generator
- Excel Export Service
- Queue Jobs

### 2.3. Mô hình hoạt động trong Laravel + Filament

```
Request → Route → Middleware → Filament Resource
                                    ↓
                            ┌───────┴───────┐
                            ↓               ↓
                        Service         Action
                            ↓               ↓
                        Repository ←────────┘
                            ↓
                        Model
                            ↓
                        Database
                            ↓
                        Response → Filament UI
```

**Luồng xử lý chi tiết:**
1. User tương tác với Filament Table/Form
2. Filament Resource nhận action
3. Resource gọi Service/Action xử lý
4. Service thực hiện business logic
5. Repository/Model truy vấn DB
6. Data trả về Service
7. Service xử lý và trả về Resource
8. Filament render UI với notification

## 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 3.1. Sơ đồ ERD (Entity Relationship Diagram)

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│    USERS     │1      n │ APPOINTMENTS │n      1 │   DOCTORS    │
│──────────────│◄────────│──────────────│────────►│──────────────│
│ id (PK)      │         │ id (PK)      │         │ id (PK)      │
│ name         │         │ patient_id   │         │ user_id (FK) │
│ email        │         │ doctor_id    │         │ specialty    │
│ password     │         │ date         │         │ license_no   │
│ role         │         │ time_slot    │         │ phone        │
└──────────────┘         │ status       │         └──────────────┘
       │                 └──────────────┘                 │
       │1                        │1                       │1
       │                         │                        │
       ↓n                        ↓n                       ↓n
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│   PATIENTS   │         │   MEDICAL    │         │   DOCTOR     │
│──────────────│         │   RECORDS    │         │  SCHEDULES   │
│ id (PK)      │         │──────────────│         │──────────────│
│ user_id (FK) │         │ id (PK)      │         │ id (PK)      │
│ date_of_birth│◄────┐   │ patient_id   │         │ doctor_id    │
│ gender       │     │   │ doctor_id    │         │ day_of_week  │
│ blood_type   │     │   │ appointment  │         │ start_time   │
│ phone        │     │   │ diagnosis    │         │ end_time     │
│ address      │     │   │ symptoms     │         │ is_available │
└──────────────┘     │   │ treatment    │         └──────────────┘
                     │   └──────────────┘
                     │           │1
                     │           │
                     │           ↓n
                     │   ┌──────────────┐
                     │   │PRESCRIPTIONS │
                     │   │──────────────│
                     │   │ id (PK)      │
                     │   │ record_id    │
                     │   │ medicine_name│
                     │   │ dosage       │
                     │   │ frequency    │
                     │   │ duration     │
                     │   │ notes        │
                     │   └──────────────┘
                     │
                     └───────────┐
                                 │1
                                 │
                                 ↓n
                         ┌──────────────┐
                         │   MEDICAL    │
                         │   HISTORY    │
                         │──────────────│
                         │ id (PK)      │
                         │ patient_id   │
                         │ condition    │
                         │ diagnosis_date│
                         │ status       │
                         │ notes        │
                         └──────────────┘
```

### 3.2. Danh sách các bảng và mối quan hệ

#### Bảng chính:

**1. users** (Người dùng hệ thống)
- Lưu thông tin tất cả user (admin, doctor, receptionist, patient)
- Relationship: 1-1 với doctors, patients
- Index: email, role

**2. patients** (Bệnh nhân)
- Thông tin chi tiết bệnh nhân
- Relationship: 1-1 với users; 1-n với appointments, medical_records
- Index: user_id, phone, patient_code

**3. doctors** (Bác sĩ)
- Thông tin chi tiết bác sĩ
- Relationship: 1-1 với users; 1-n với appointments, doctor_schedules
- Index: user_id, specialty, license_number

**4. appointments** (Lịch hẹn khám)
- Quản lý lịch khám bệnh
- Relationship: n-1 với patients, doctors
- Index: patient_id, doctor_id, appointment_date, status

**5. doctor_schedules** (Lịch làm việc bác sĩ)
- Lưu khung giờ làm việc của bác sĩ
- Relationship: n-1 với doctors
- Index: doctor_id, day_of_week

**6. medical_records** (Hồ sơ bệnh án)
- Lưu thông tin khám bệnh
- Relationship: n-1 với patients, doctors, appointments; 1-n với prescriptions
- Index: patient_id, doctor_id, appointment_id, visit_date

**7. prescriptions** (Đơn thuốc)
- Chi tiết đơn thuốc
- Relationship: n-1 với medical_records
- Index: medical_record_id

**8. medical_history** (Tiền sử bệnh)
- Lịch sử bệnh lý của bệnh nhân
- Relationship: n-1 với patients
- Index: patient_id

**9. notifications** (Thông báo)
- Lưu thông báo, nhắc lịch
- Relationship: n-1 với users
- Index: user_id, read_at, type

**10. settings** (Cấu hình hệ thống)
- Các thiết lập chung
- Relationship: Không có FK
- Index: key

### 3.3. Thiết kế chi tiết các bảng

#### 3.3.1. Bảng: users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'receptionist', 'patient') DEFAULT 'patient',
    avatar VARCHAR(255),
    phone VARCHAR(20),
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.2. Bảng: patients
```sql
CREATE TABLE patients (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    patient_code VARCHAR(50) UNIQUE NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    province VARCHAR(100),
    district VARCHAR(100),
    ward VARCHAR(100),
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    emergency_contact_relationship VARCHAR(100),
    insurance_number VARCHAR(100),
    insurance_provider VARCHAR(255),
    allergies TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_patient_code (patient_code),
    INDEX idx_phone (phone),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.3. Bảng: doctors
```sql
CREATE TABLE doctors (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    doctor_code VARCHAR(50) UNIQUE NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    license_number VARCHAR(100) UNIQUE NOT NULL,
    qualification VARCHAR(500),
    experience_years INT DEFAULT 0,
    phone VARCHAR(20) NOT NULL,
    consultation_fee DECIMAL(10,2) DEFAULT 0,
    bio TEXT,
    status ENUM('active', 'inactive', 'on_leave') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_doctor_code (doctor_code),
    INDEX idx_specialty (specialty),
    INDEX idx_license_number (license_number),
    INDEX idx_status (status),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.4. Bảng: doctor_schedules
```sql
CREATE TABLE doctor_schedules (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    doctor_id BIGINT UNSIGNED NOT NULL,
    day_of_week ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    slot_duration INT DEFAULT 30 COMMENT 'Minutes per slot',
    max_patients_per_slot INT DEFAULT 1,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_doctor_id (doctor_id),
    INDEX idx_day_of_week (day_of_week),
    INDEX idx_is_available (is_available),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.5. Bảng: appointments
```sql
CREATE TABLE appointments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    appointment_number VARCHAR(50) UNIQUE NOT NULL,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    slot_duration INT DEFAULT 30,
    reason TEXT,
    status ENUM('scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show') DEFAULT 'scheduled',
    priority ENUM('normal', 'urgent', 'emergency') DEFAULT 'normal',
    notes TEXT,
    cancelled_reason TEXT,
    cancelled_at TIMESTAMP NULL,
    confirmed_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    reminder_sent_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_appointment_number (appointment_number),
    INDEX idx_patient_id (patient_id),
    INDEX idx_doctor_id (doctor_id),
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_status (status),
    INDEX idx_date_time (appointment_date, appointment_time),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.6. Bảng: medical_records
```sql
CREATE TABLE medical_records (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    record_number VARCHAR(50) UNIQUE NOT NULL,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NOT NULL,
    appointment_id BIGINT UNSIGNED NULL,
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    
    -- Vital signs
    weight DECIMAL(5,2) COMMENT 'kg',
    height DECIMAL(5,2) COMMENT 'cm',
    temperature DECIMAL(4,2) COMMENT 'Celsius',
    blood_pressure_systolic INT,
    blood_pressure_diastolic INT,
    heart_rate INT COMMENT 'bpm',
    respiratory_rate INT COMMENT 'per minute',
    
    -- Clinical information
    chief_complaint TEXT NOT NULL,
    symptoms TEXT,
    diagnosis TEXT NOT NULL,
    treatment_plan TEXT,
    lab_tests_ordered TEXT,
    imaging_ordered TEXT,
    follow_up_instructions TEXT,
    follow_up_date DATE,
    
    notes TEXT,
    status ENUM('draft', 'completed', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_record_number (record_number),
    INDEX idx_patient_id (patient_id),
    INDEX idx_doctor_id (doctor_id),
    INDEX idx_appointment_id (appointment_id),
    INDEX idx_visit_date (visit_date),
    INDEX idx_status (status),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.7. Bảng: prescriptions
```sql
CREATE TABLE prescriptions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    medical_record_id BIGINT UNSIGNED NOT NULL,
    medicine_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    frequency VARCHAR(100) NOT NULL COMMENT 'e.g., 2 times per day',
    duration VARCHAR(100) NOT NULL COMMENT 'e.g., 7 days',
    quantity INT NOT NULL,
    instructions TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_medical_record_id (medical_record_id),
    FOREIGN KEY (medical_record_id) REFERENCES medical_records(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.8. Bảng: medical_history
```sql
CREATE TABLE medical_history (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT UNSIGNED NOT NULL,
    condition_name VARCHAR(255) NOT NULL,
    diagnosis_date DATE,
    status ENUM('current', 'resolved', 'chronic') DEFAULT 'current',
    severity ENUM('mild', 'moderate', 'severe'),
    treatment TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_patient_id (patient_id),
    INDEX idx_status (status),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.9. Bảng: notifications
```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(100) NOT NULL COMMENT 'appointment_reminder, appointment_cancelled, etc.',
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    action_url VARCHAR(500),
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_type (type),
    INDEX idx_read_at (read_at),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.3.10. Bảng: settings
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(100) UNIQUE NOT NULL,
    value TEXT,
    type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    group_name VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_key (key),
    INDEX idx_group (group_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3.4. Indexes và Optimization

**Indexes cần thiết:**
```sql
-- Appointments - tìm kiếm theo ngày và bác sĩ
ALTER TABLE appointments ADD INDEX idx_doctor_date (doctor_id, appointment_date);
ALTER TABLE appointments ADD INDEX idx_patient_date (patient_id, appointment_date);

-- Medical Records - tra cứu lịch sử khám
ALTER TABLE medical_records ADD INDEX idx_patient_visit (patient_id, visit_date);
ALTER TABLE medical_records ADD INDEX idx_doctor_visit (doctor_id, visit_date);

-- Full-text search
ALTER TABLE medical_records ADD FULLTEXT idx_search (chief_complaint, diagnosis, symptoms);
ALTER TABLE patients ADD FULLTEXT idx_patient_search (patient_code, phone);
```

**Query Optimization:**
- Sử dụng Eager Loading cho relationships
- Cache danh sách bác sĩ, lịch làm việc (TTL: 1 giờ)
- Pagination cho danh sách bệnh nhân, lịch hẹn (20 items/page)
- Index cho các cột thường dùng trong WHERE, JOIN, ORDER BY

## 4. THIẾT KẾ CHỨC NĂNG CHI TIẾT

### 4.1. Module Quản lý Bệnh nhân

#### 4.1.1. Chức năng Admin/Receptionist

**Danh sách bệnh nhân (Filament Table):**

*Cột hiển thị:*
- Mã BN (patient_code)
- Họ tên
- Ngày sinh / Tuổi
- Giới tính
- Số điện thoại
- Ngày đăng ký
- Trạng thái
- Thao tác (View, Edit, Delete)

*Tìm kiếm và lọc:*
- Tìm kiếm theo: Mã BN, Họ tên, SĐT, Email
- Lọc theo: Giới tính, Nhóm tuổi, Trạng thái
- Sắp xếp theo: Ngày đăng ký, Họ tên, Tuổi

*Bulk Actions:*
- Export danh sách Excel/PDF
- Gửi thông báo hàng loạt
- Kích hoạt/Vô hiệu hóa nhiều BN

**Form thêm/sửa bệnh nhân (Filament Form):**

*Section 1: Thông tin tài khoản*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN TÀI KHOẢN                         │
├─────────────────────────────────────────────┤
│ Họ và tên (*): [___________________]        │
│ Email (*): [___________________________]    │
│ Số điện thoại (*): [___________________]    │
│ Mật khẩu (*): [________________________]    │
│ (Chỉ khi tạo mới)                           │
│                                             │
│ ☐ Gửi email thông tin đăng nhập             │
└─────────────────────────────────────────────┘
```

*Section 2: Thông tin cá nhân*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN CÁ NHÂN                           │
├─────────────────────────────────────────────┤
│ Mã bệnh nhân: [BN-XXXXXX] (Auto)           │
│                                             │
│ Ngày sinh (*): [DD/MM/YYYY]                │
│ Giới tính (*): ○ Nam  ○ Nữ  ○ Khác         │
│ Nhóm máu: [Select ▼]                       │
│                                             │
│ Địa chỉ chi tiết: [___________________]    │
│ Tỉnh/Thành phố: [Select ▼]                │
│ Quận/Huyện: [Select ▼]                     │
│ Phường/Xã: [Select ▼]                      │
└─────────────────────────────────────────────┘
```

*Section 3: Người liên hệ khẩn cấp*
```
┌─────────────────────────────────────────────┐
│ NGƯỜI LIÊN HỆ KHẨN CẤP                      │
├─────────────────────────────────────────────┤
│ Họ tên: [__________________________]       │
│ Số điện thoại: [___________________]       │
│ Mối quan hệ: [_____________________]       │
└─────────────────────────────────────────────┘
```

*Section 4: Bảo hiểm y tế*
```
┌─────────────────────────────────────────────┐
│ BẢO HIỂM Y TẾ                               │
├─────────────────────────────────────────────┤
│ Số thẻ BHYT: [_____________________]       │
│ Nơi cấp: [_________________________]       │
│ Giá trị từ: [DD/MM/YYYY] đến [DD/MM/YYYY] │
└─────────────────────────────────────────────┘
```

*Section 5: Thông tin y tế*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN Y TẾ                              │
├─────────────────────────────────────────────┤
│ Dị ứng (nếu có):                            │
│ [_____________________________________]     │
│                                             │
│ Ghi chú:                                    │
│ [_____________________________________]     │
│ [_____________________________________]     │
└─────────────────────────────────────────────┘
```

**Validation:**
```php
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users,email,' . $userId,
'phone' => 'required|regex:/^0[3|5|7|8|9][0-9]{8}$/|unique:patients,phone,' . $id,
'date_of_birth' => 'required|date|before:today',
'gender' => 'required|in:male,female,other',
'address' => 'required|string',
'province' => 'required|string',
'district' => 'required|string',
'ward' => 'required|string',
'emergency_contact_phone' => 'nullable|regex:/^0[3|5|7|8|9][0-9]{8}$/',
```

**Xem chi tiết bệnh nhân:**

*Layout:*
```
┌─────────────────────────────────────────────────────────┐
│ BỆNH NHÂN: NGUYỄN VAN A (BN-000123)                    │
├─────────────────────────────────────────────────────────┤
│ [Thông tin] [Lịch sử khám] [Đơn thuốc] [Hẹn khám]     │
├─────────────────────────────────────────────────────────┤
│                                                         │
│ TAB: THÔNG TIN CƠ BẢN                                  │
│ ┌─────────────────────────────────────────────────────┐│
│ │ 📋 Thông tin cá nhân                                ││
│ │ Họ tên: Nguyễn Văn A                               ││
│ │ Ngày sinh: 15/03/1985 (39 tuổi)                    ││
│ │ Giới tính: Nam                                      ││
│ │ Nhóm máu: O+                                        ││
│ │ Điện thoại: 0901234567                             ││
│ │ Email: nguyenvana@email.com                        ││
│ │ Địa chỉ: 123 Đường ABC, Phường X, Quận Y, TP.HCM   ││
│ └─────────────────────────────────────────────────────┘│
│ ┌─────────────────────────────────────────────────────┐│
│ │ 🚨 Liên hệ khẩn cấp                                ││
│ │ Họ tên: Nguyễn Thị B                               ││
│ │ SĐT: 0987654321                                    ││
│ │ Quan hệ: Vợ                                        ││
│ └─────────────────────────────────────────────────────┘│
│ ┌─────────────────────────────────────────────────────┐│
│ │ 🏥 Bảo hiểm y tế                                    ││
│ │ Số thẻ: DN1234567890                               ││
│ │ Nơi cấp: BHXH TP.HCM                               ││
│ │ Hiệu lực: 01/01/2024 - 31/12/2024                  ││
│ └─────────────────────────────────────────────────────┘│
│ ┌─────────────────────────────────────────────────────┐│
│ │ ⚠️ Cảnh báo y tế                                    ││
│ │ Dị ứng: Penicillin, phấn hoa                       ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ [Sửa thông tin] [In hồ sơ] [Đặt lịch khám]            │
└─────────────────────────────────────────────────────────┘
```

**Tab lịch sử khám:**
```
┌─────────────────────────────────────────────────────────┐
│ LỊCH SỬ KHÁM BỆNH (24 lần khám)                        │
├─────────────────────────────────────────────────────────┤
│ [Tìm kiếm...] [Lọc: Tất cả ▼] [Từ ngày - Đến ngày]    │
├──────┬──────────┬────────────┬─────────────┬──────────┤
│ Ngày │ Bác sĩ   │ Chẩn đoán  │ Điều trị    │ Trạng thái│
├──────┼──────────┼────────────┼─────────────┼──────────┤
│15/12 │BS. Nguyễn│Viêm họng   │Kháng sinh   │Hoàn thành│
│      │Văn C     │cấp         │Paracetamol  │          │
│      │          │            │[Xem chi tiết]│         │
├──────┼──────────┼────────────┼─────────────┼──────────┤
│20/11 │BS. Trần  │Cảm cúm     │Nghỉ ngơi    │Hoàn thành│
│      │Thị D     │            │Uống nhiều   │          │
│      │          │            │nước         │          │
│      │          │            │[Xem chi tiết]│         │
├──────┴──────────┴────────────┴─────────────┴──────────┤
│ [← Trước] [1] [2] [3] [4] [5] [Sau →]                 │
└─────────────────────────────────────────────────────────┘
```

#### 4.1.2. Chức năng của Bệnh nhân (Patient Portal - Optional)

**Dashboard bệnh nhân:**
```
┌─────────────────────────────────────────────────────────┐
│ Xin chào, Nguyễn Văn A                   [Đăng xuất]   │
├─────────────────────────────────────────────────────────┤
│ ┌─────────────────┐  ┌─────────────────┐               │
│ │ 📅 Lịch hẹn sắp│  │ 📋 Hồ sơ của tôi│               │
│ │ tới: 2         │  │                 │               │
│ │ [Xem chi tiết] │  │ [Xem hồ sơ]    │               │
│ └─────────────────┘  └─────────────────┘               │
│                                                         │
│ LỊCH HẸN SẮP TỚI                                        │
│ ┌─────────────────────────────────────────────────────┐│
│ │ 📅 20/12/2024 - 09:00                               ││
│ │ 👨‍⚕️ Bác sĩ: BS. Nguyễn Văn C                       ││
│ │ 🏥 Chuyên khoa: Nội tổng quát                       ││
│ │ 📝 Lý do: Đau bụng, khó tiêu               │
│                                             │
│ 🔔 Trạng thái: Đã xác nhận                 │
│                                             │
│ Ghi chú: Bệnh nhân yêu cầu khám sớm        │
│                                             │
│ [Bắt đầu khám] [Hủy lịch] [Đổi lịch]      │
│ [In phiếu hẹn] [Gửi nhắc lịch]            │
└─────────────────────────────────────────────┘
```

**Các trạng thái lịch hẹn:**

1. **Scheduled (Đã đặt lịch)**
    - Mới tạo, chưa xác nhận
    - Hành động: Xác nhận, Hủy, Đổi lịch

2. **Confirmed (Đã xác nhận)**
    - Admin/Bác sĩ đã xác nhận
    - Gửi nhắc lịch trước 24h và 2h
    - Hành động: Bắt đầu khám, Hủy, Đổi lịch

3. **In Progress (Đang khám)**
    - Bệnh nhân đã đến, đang khám
    - Hành động: Hoàn thành, Tạo hồ sơ khám

4. **Completed (Hoàn thành)**
    - Đã khám xong
    - Có hồ sơ khám bệnh kèm theo
    - Hành động: Xem hồ sơ, Đặt lịch tái khám

5. **Cancelled (Đã hủy)**
    - Bệnh nhân/Admin hủy
    - Lưu lý do hủy
    - Hành động: Đặt lịch mới

6. **No Show (Không đến)**
    - Bệnh nhân không đến khám
    - Ghi nhận vào lịch sử
    - Hành động: Liên hệ, Đặt lịch mới

**Nhắc lịch tự động:**

*Cấu hình reminder:*
```php
// Job chạy mỗi giờ kiểm tra appointment cần nhắc
class SendAppointmentReminderJob
{
    public function handle()
    {
        // Nhắc trước 24 giờ
        $appointments24h = Appointment::where('appointment_date', 
            now()->addDay()->toDateString())
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
            ->get();
            
        foreach ($appointments24h as $appointment) {
            // Gửi email
            Mail::to($appointment->patient->user->email)
                ->send(new AppointmentReminder($appointment, '24h'));
            
            // Gửi SMS (optional)
            if ($appointment->patient->phone) {
                SMS::send($appointment->patient->phone, 
                    "Nhắc lịch: Bạn có lịch khám vào {$appointment->appointment_date} 
                    lúc {$appointment->appointment_time} với BS. {$appointment->doctor->user->name}");
            }
            
            // Lưu notification
            Notification::create([
                'user_id' => $appointment->patient->user_id,
                'type' => 'appointment_reminder',
                'title' => 'Nhắc lịch khám',
                'message' => "Bạn có lịch khám vào ngày mai...",
            ]);
            
            $appointment->update(['reminder_sent_at' => now()]);
        }
        
        // Tương tự cho reminder trước 2 giờ
    }
}
```

*Nội dung email nhắc lịch:*
```
Kính gửi Anh/Chị Nguyễn Văn A,

Đây là email nhắc lịch khám bệnh tại Phòng khám ABC.

THÔNG TIN LỊCH KHÁM:
- Mã hẹn: APT-20241218-001
- Thời gian: Thứ 4, 18/12/2024 lúc 09:00
- Bác sĩ: BS. Nguyễn Văn C
- Chuyên khoa: Nội tổng quát
- Địa điểm: Phòng khám số 123, Đường ABC, TP.HCM

LƯU Ý:
- Vui lòng đến trước 15 phút để làm thủ tục
- Mang theo thẻ BHYT (nếu có)
- Mang theo kết quả xét nghiệm cũ (nếu có)

Nếu không thể đến, vui lòng hủy lịch trước 24h.

Trân trọng,
Phòng khám ABC
```

### 4.4. Module Quản lý Khám bệnh

#### 4.4.1. Phiếu khám bệnh (Medical Record)

**Quy trình khám bệnh:**

*Bước 1: Bắt đầu khám*
```
Từ lịch hẹn → Click "Bắt đầu khám"
→ Appointment status = 'in_progress'
→ Mở form phiếu khám bệnh
```

*Bước 2: Nhập thông tin khám*

**Form phiếu khám (Filament):**

*Section 1: Thông tin cơ bản*
```
┌─────────────────────────────────────────────┐
│ PHIẾU KHÁM BỆNH                             │
│ Mã phiếu: MR-20241218-001 (Auto)           │
├─────────────────────────────────────────────┤
│ Bệnh nhân: Nguyễn Văn A (BN-000123)        │
│ Ngày sinh: 15/03/1985 (39 tuổi) - Nam     │
│ Điện thoại: 0901234567                     │
│                                             │
│ Bác sĩ: BS. Nguyễn Văn C                   │
│ Ngày khám: 18/12/2024  Giờ: 09:00         │
└─────────────────────────────────────────────┘
```

*Section 2: Sinh hiệu*
```
┌─────────────────────────────────────────────┐
│ SINH HIỆU                                   │
├─────────────────────────────────────────────┤
│ Cân nặng (kg): [____]  Chiều cao (cm): [__]│
│                                             │
│ Nhiệt độ (°C): [____]                      │
│                                             │
│ Huyết áp:                                   │
│ Tâm thu: [___] mmHg  Tâm trương: [___] mmHg│
│                                             │
│ Nhịp tim: [___] bpm                        │
│                                             │
│ Nhịp thở: [___] lần/phút                   │
└─────────────────────────────────────────────┘
```

*Section 3: Thông tin lâm sàng*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN LÂM SÀNG                          │
├─────────────────────────────────────────────┤
│ Lý do khám (*):                            │
│ [_____________________________________]     │
│ [_____________________________________]     │
│                                             │
│ Triệu chứng (*):                           │
│ [WYSIWYG Editor]                            │
│ - Mô tả chi tiết các triệu chứng           │
│ - Thời gian xuất hiện                      │
│ - Mức độ nghiêm trọng                      │
│                                             │
│ Tiền sử bệnh liên quan:                    │
│ [Load từ medical_history của BN]           │
│ - Tăng huyết áp (2020 - Hiện tại)         │
│ - Viêm dạ dày (2022 - Đã khỏi)            │
│                                             │
│ Dị ứng đã biết:                            │
│ [Load từ patient.allergies]                │
│ ⚠️ Penicillin, Phấn hoa                   │
└─────────────────────────────────────────────┘
```

*Section 4: Chẩn đoán*
```
┌─────────────────────────────────────────────┐
│ CHẨN ĐOÁN                                   │
├─────────────────────────────────────────────┤
│ Chẩn đoán bệnh (*):                        │
│ [_____________________________________]     │
│ [_____________________________________]     │
│                                             │
│ Mã ICD-10: [_______] (Optional)            │
│                                             │
│ Chi tiết chẩn đoán:                        │
│ [WYSIWYG Editor]                            │
│ - Kết quả khám lâm sàng                    │
│ - Phân tích triệu chứng                    │
│ - Nhận định của bác sĩ                     │
└─────────────────────────────────────────────┘
```

*Section 5: Chỉ định*
```
┌─────────────────────────────────────────────┐
│ CHỈ ĐỊNH XÉT NGHIỆM / CHẨN ĐOÁN HÌNH ẢNH    │
├─────────────────────────────────────────────┤
│ ☐ Xét nghiệm máu                            │
│ ☐ Xét nghiệm nước tiểu                      │
│ ☐ X-Quang                                   │
│ ☐ Siêu âm                                   │
│ ☐ CT Scan                                   │
│ ☐ MRI                                       │
│ ☐ Nội soi                                   │
│                                             │
│ Chi tiết chỉ định:                          │
│ [_____________________________________]     │
│ [_____________________________________]     │
└─────────────────────────────────────────────┘
```

*Section 6: Kế hoạch điều trị*
```
┌─────────────────────────────────────────────┐
│ KẾ HOẠCH ĐIỀU TRỊ                           │
├─────────────────────────────────────────────┤
│ Phương pháp điều trị:                       │
│ [WYSIWYG Editor]                            │
│ - Điều trị bằng thuốc                      │
│ - Chế độ ăn uống                           │
│ - Chế độ sinh hoạt                         │
│ - Các lưu ý khác                           │
│                                             │
│ Hướng dẫn tái khám:                        │
│ [_____________________________________]     │
│                                             │
│ Ngày tái khám: [DD/MM/YYYY] (Optional)     │
└─────────────────────────────────────────────┘
```

*Section 7: Ghi chú*
```
┌─────────────────────────────────────────────┐
│ GHI CHÚ                                     │
├─────────────────────────────────────────────┤
│ [_____________________________________]     │
│ [_____________________________________]     │
│ [_____________________________________]     │
└─────────────────────────────────────────────┘
```

**Nút hànhý do: Tái khám                                  ││
│ │ [Hủy lịch] [Xem chi tiết]                          ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ [Đặt lịch mới] [Xem lịch sử khám] [Cập nhật hồ sơ]    │
└─────────────────────────────────────────────────────────┘
```

### 4.2. Module Quản lý Bác sĩ

#### 4.2.1. Chức năng Admin

**Danh sách bác sĩ (Filament Table):**

*Cột hiển thị:*
- Mã BS (doctor_code)
- Họ tên
- Chuyên khoa
- Số giấy phép hành nghề
- SĐT
- Kinh nghiệm (năm)
- Phí khám
- Trạng thái
- Thao tác

**Form thêm/sửa bác sĩ:**

*Section 1: Thông tin tài khoản*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN TÀI KHOẢN                         │
├─────────────────────────────────────────────┤
│ Họ và tên (*): [___________________]        │
│ Email (*): [___________________________]    │
│ Mật khẩu (*): [________________________]    │
│ Role: Doctor (Fixed)                        │
└─────────────────────────────────────────────┘
```

*Section 2: Thông tin chuyên môn*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN CHUYÊN MÔN                        │
├─────────────────────────────────────────────┤
│ Mã bác sĩ: [BS-XXXXXX] (Auto)             │
│                                             │
│ Chuyên khoa (*): [Select ▼]               │
│ - Nội tổng quát                             │
│ - Ngoại khoa                                │
│ - Nhi khoa                                  │
│ - Sản phụ khoa                              │
│ - Tim mạch                                  │
│ - Da liễu                                   │
│ - Tai Mũi Họng                              │
│                                             │
│ Số giấy phép (*): [_______________]        │
│                                             │
│ Trình độ học vấn:                           │
│ [_____________________________________]     │
│                                             │
│ Kinh nghiệm (năm): [____]                  │
│                                             │
│ Phí khám (VNĐ): [____________]             │
└─────────────────────────────────────────────┘
```

*Section 3: Thông tin liên hệ*
```
┌─────────────────────────────────────────────┐
│ THÔNG TIN LIÊN HỆ                           │
├─────────────────────────────────────────────┤
│ Số điện thoại (*): [___________________]    │
│                                             │
│ Tiểu sử/Giới thiệu:                        │
│ [WYSIWYG Editor]                            │
│ - Quá trình đào tạo                         │
│ - Kinh nghiệm làm việc                      │
│ - Chuyên môn điều trị                       │
└─────────────────────────────────────────────┘
```

*Section 4: Trạng thái*
```
┌─────────────────────────────────────────────┐
│ TRẠNG THÁI                                  │
├─────────────────────────────────────────────┤
│ ○ Đang hoạt động                            │
│ ○ Tạm nghỉ                                  │
│ ○ Ngưng hoạt động                           │
└─────────────────────────────────────────────┘
```

**Quản lý lịch làm việc:**

*Giao diện:*
```
┌─────────────────────────────────────────────────────────┐
│ LỊCH LÀM VIỆC - BS. NGUYỄN VĂN C                       │
├─────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────────────────┐│
│ │ ☐ Thứ 2: 08:00 - 12:00, 14:00 - 17:00             ││
│ │   Thời gian khám/ca: 30 phút                       ││
│ │   Tối đa: 1 bệnh nhân/ca                           ││
│ │   [Sửa] [Xóa]                                      ││
│ ├─────────────────────────────────────────────────────┤│
│ │ ☐ Thứ 3: 08:00 - 12:00                            ││
│ │   Thời gian khám/ca: 30 phút                       ││
│ │   Tối đa: 1 bệnh nhân/ca                           ││
│ │   [Sửa] [Xóa]                                      ││
│ ├─────────────────────────────────────────────────────┤│
│ │ ☑ Thứ 4: Ngày nghỉ                                ││
│ ├─────────────────────────────────────────────────────┤│
│ │ ☐ Thứ 5: 08:00 - 12:00, 14:00 - 17:00             ││
│ │   Thời gian khám/ca: 30 phút                       ││
│ │   Tối đa: 1 bệnh nhân/ca                           ││
│ │   [Sửa] [Xóa]                                      ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ [+ Thêm khung giờ mới] [Sao chép sang tuần khác]      │
└─────────────────────────────────────────────────────────┘
```

*Form thêm/sửa khung giờ:*
```
┌─────────────────────────────────────────────┐
│ THÊM KHUNG GIỜ LÀM VIỆC                     │
├─────────────────────────────────────────────┤
│ Thứ trong tuần (*): [Select ▼]            │
│                                             │
│ Giờ bắt đầu (*): [HH:MM]                   │
│ Giờ kết thúc (*): [HH:MM]                  │
│                                             │
│ Thời lượng mỗi ca khám (*):                 │
│ ○ 15 phút  ○ 30 phút  ○ 45 phút  ○ 60 phút│
│                                             │
│ Số bệnh nhân tối đa/ca: [__]               │
│                                             │
│ ☐ Áp dụng cho tất cả các tuần               │
│                                             │
│ [Hủy] [Lưu]                                 │
└─────────────────────────────────────────────┘
```

**Validation lịch làm việc:**
- Không trùng khung giờ trong cùng ngày
- Giờ kết thúc > Giờ bắt đầu
- Thời lượng ca khám hợp lý (15-60 phút)
- Tổng thời gian làm việc không quá 12h/ngày

### 4.3. Module Quản lý Lịch hẹn

#### 4.3.1. Đặt lịch hẹn (Booking)

**Quy trình đặt lịch chi tiết:**

*Bước 1: Chọn bệnh nhân*
```
┌─────────────────────────────────────────────┐
│ CHỌN BỆNH NHÂN                              │
├─────────────────────────────────────────────┤
│ [Tìm kiếm bệnh nhân...              ]  [🔍]│
│                                             │
│ Hoặc:                                       │
│ [+ Thêm bệnh nhân mới]                      │
│                                             │
│ Đã chọn: Nguyễn Văn A (BN-000123)          │
│                                             │
│ [Tiếp tục →]                                │
└─────────────────────────────────────────────┘
```

*Bước 2: Chọn chuyên khoa và bác sĩ*
```
┌─────────────────────────────────────────────┐
│ CHỌN BÁC SĨ                                 │
├─────────────────────────────────────────────┤
│ Chuyên khoa (*): [Select ▼]               │
│                                             │
│ Danh sách bác sĩ:                          │
│ ┌─────────────────────────────────────────┐│
│ │ ○ BS. Nguyễn Văn C                      ││
│ │   Nội tổng quát - 10 năm kinh nghiệm    ││
│ │   Phí khám: 200.000đ                    ││
│ │   ⭐⭐⭐⭐⭐ (4.8/5)                      ││
│ ├─────────────────────────────────────────┤│
│ │ ○ BS. Trần Thị D                        ││
│ │   Nội tổng quát - 8 năm kinh nghiệm     ││
│ │   Phí khám: 180.000đ                    ││
│ │   ⭐⭐⭐⭐ (4.5/5)                       ││
│ └─────────────────────────────────────────┘│
│                                             │
│ [← Quay lại] [Tiếp tục →]                  │
└─────────────────────────────────────────────┘
```

*Bước 3: Chọn ngày và giờ*
```
┌─────────────────────────────────────────────┐
│ CHỌN NGÀY VÀ GIỜ KHÁM                       │
├─────────────────────────────────────────────┤
│ Bác sĩ: BS. Nguyễn Văn C                   │
│                                             │
│ Chọn ngày (*):                              │
│ ┌───────────────────────────────┐          │
│ │    Tháng 12/2024              │          │
│ │ CN  T2  T3  T4  T5  T6  T7   │          │
│ │  1   2   3   4   5   6   7   │          │
│ │  8   9  10  11  12  13  14   │          │
│ │ 15  16  17 [18] 19  20  21   │          │
│ │ 22  23  24  25  26  27  28   │          │
│ │ 29  30  31                   │          │
│ └───────────────────────────────┘          │
│                                             │
│ Đã chọn: Thứ 4, 18/12/2024                 │
│                                             │
│ Các khung giờ có sẵn:                      │
│ [08:00] [08:30] [09:00] [09:30] [10:00]   │
│ [10:30] [11:00] [11:30] [Đã đặt] [14:00]  │
│ [14:30] [15:00] [15:30] [16:00] [16:30]   │
│                                             │
│ Đã chọn: 09:00 - 09:30                     │
│                                             │
│ [← Quay lại] [Tiếp tục →]                  │
└─────────────────────────────────────────────┘
```

*Bước 4: Xác nhận thông tin*
```
┌─────────────────────────────────────────────┐
│ XÁC NHẬN ĐẶT LỊCH                           │
├─────────────────────────────────────────────┤
│ Bệnh nhân: Nguyễn Văn A (BN-000123)        │
│ Ngày sinh: 15/03/1985 (39 tuổi)           │
│ SĐT: 0901234567                            │
│                                             │
│ Bác sĩ: BS. Nguyễn Văn C                   │
│ Chuyên khoa: Nội tổng quát                 │
│                                             │
│ Thời gian: Thứ 4, 18/12/2024              │
│            09:00 - 09:30                   │
│                                             │
│ Lý do khám (*):                            │
│ [_____________________________________]     │
│ [_____________________________________]     │
│                                             │
│ Độ ưu tiên:                                 │
│ ○ Bình thường  ○ Khẩn  ○ Cấp cứu          │
│                                             │
│ Ghi chú:                                    │
│ [_____________________________________]     │
│                                             │
│ ☐ Gửi thông báo nhắc lịch qua email        │
│ ☐ Gửi thông báo nhắc lịch qua SMS          │
│                                             │
│ [← Quay lại] [Xác nhận đặt lịch]          │
└─────────────────────────────────────────────┘
```

**Nghiệp vụ xử lý đặt lịch:**

*Validation:*
1. Kiểm tra bệnh nhân tồn tại
2. Kiểm tra bác sĩ đang hoạt động
3. Kiểm tra ngày khám >= ngày hiện tại
4. Kiểm tra khung giờ còn trống
5. Kiểm tra bác sĩ có làm việc vào ngày đó
6. Kiểm tra không trùng lịch hẹn của bệnh nhân

*Xử lý khi đặt lịch thành công:*
1. Tạo appointment với status = 'scheduled'
2. Generate appointment_number (VD: APT-20241218-001)
3. Gửi email xác nhận cho bệnh nhân
4. Gửi thông báo cho bác sĩ
5. Tạo reminder job (nhắc trước 24h và 2h)
6. Hiển thị thông báo thành công với mã hẹn

#### 4.3.2. Quản lý lịch hẹn (Calendar View)

**Giao diện lịch:**
```
┌─────────────────────────────────────────────────────────┐
│ LỊCH HẸN KHÁM          [Ngày] [Tuần] [Tháng]          │
├─────────────────────────────────────────────────────────┤
│ Bác sĩ: [Tất cả ▼]  Ngày: [18/12/2024]  [< Hôm nay >] │
├─────────────────────────────────────────────────────────┤
│      │ BS. Nguyễn C │ BS. Trần D   │ BS. Lê E       │
├──────┼──────────────┼──────────────┼────────────────┤
│08:00 │ BN: Nguyễn A│              │ BN: Phạm G    │
│      │ Tel: 090xxx │              │ Tel: 091xxx   │
│      │ [Confirmed] │              │ [Scheduled]   │
├──────┼──────────────┼──────────────┼────────────────┤
│08:30 │              │ BN: Trần B   │                │
│      │              │ Tel: 098xxx │                │
│      │              │ [In Progress]│                │
├──────┼──────────────┼──────────────┼────────────────┤
│09:00 │              │              │                │
│      │   [Trống]    │   [Trống]    │   [Trống]     │
├──────┼──────────────┼──────────────┼────────────────┤
│09:30 │ BN: Lê C    │              │                │
│      │ Tel: 097xxx │              │                │
│      │ [Scheduled] │              │                │
└─────────────────────────────────────────────────────────┘

Chú thích:
🟢 Scheduled    🔵 Confirmed    🟡 In Progress
🟢 Completed    🔴 Cancelled    ⚫ No Show
```

**Chi tiết lịch hẹn:**
```
┌─────────────────────────────────────────────┐
│ CHI TIẾT LỊCH HẸN                           │
│ Mã: APT-20241218-001                       │
├─────────────────────────────────────────────┤
│ 👤 Bệnh nhân: Nguyễn Văn A (BN-000123)     │
│    SĐT: 0901234567                         │
│    Tuổi: 39                                 │
│                                             │
│ 👨‍⚕️ Bác sĩ: BS. Nguyễn Văn C              │
│    Chuyên khoa: Nội tổng quát              │
│                                             │
│ 📅 Thời gian: Thứ 4, 18/12/2024           │
│              09:00 - 09:30                 │
│                                             │
│ 📝 L
