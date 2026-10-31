# KIỂM ĐỊNH PHẦN MỀM GIỮA KỲ

# Travel Mate – Website Đặt Phòng Khách Sạn Trực Tuyến

## Giới thiệu

Đây là đồ án môn Kiểm định phần mềm sử dụng hệ thống Travel Mate làm đối tượng kiểm thử.

Travel Mate là website đặt phòng khách sạn trực tuyến kết nối khách hàng với chủ cơ sở lưu trú và quản trị viên. Hệ thống hỗ trợ tìm kiếm khách sạn, đặt phòng, thanh toán, quản lý lưu trú, đánh giá và quản lý doanh thu.

video thuyết trình dự án được đặt trong folder VIDEO_THUYET_TRINH

---

## Mục tiêu kiểm định

- Phân tích yêu cầu phần mềm (SRS).
- Xây dựng kế hoạch kiểm thử (Test Plan).
- Kiểm thử hộp trắng (White-box Testing).
- Kiểm thử hộp đen (Black-box Testing).
- Kiểm thử phân quyền và luồng nghiệp vụ.
- Đánh giá chất lượng phần mềm theo ISO/IEC 25010.
- Tổng hợp và phân tích kết quả kiểm thử.

---

## Công nghệ sử dụng

- Laravel 12
- PHP 8.2+
- MySQL / MariaDB
- Blade Template
- Tailwind CSS
- Vite
- PHPUnit
- Selenium IDE
- XAMPP

---

## Nội dung kiểm định

### Phần I: Software Requirement Specification (SRS)

- Đặc tả yêu cầu phần mềm.
- Mô tả bài toán.
- Use Case Diagram.
- ERD.
- Class Diagram.
- Activity Diagram.
- Sequence Diagram.

### Phần II: Test Plan

- Phạm vi kiểm thử.
- Môi trường kiểm thử.
- Kỹ thuật kiểm thử.
- Bộ Test Case.
- Điều kiện nghiệm thu.

### Phần III: Thực hiện kiểm thử

#### White-box Testing

- Phân tích route.
- Phân tích luồng đăng nhập.
- Phân tích quy trình đặt phòng.
- Phân tích chống overbooking.
- Phân tích thanh toán VNPAY.
- Kiểm thử PHPUnit.

#### Black-box Testing

- Public/Auth.
- Customer.
- Owner.
- Admin.

#### Selenium IDE

- Tự động hóa đăng nhập.

### Phần IV: Report

- Tổng hợp kết quả kiểm thử.
- Phân tích lỗi.
- Đánh giá rủi ro.
- Kết luận.

---

## Kết quả kiểm thử

| Nhóm chức năng | Số test case | Đạt |
|---------------|--------------|-----|
| Public/Auth | 10 | 10 |
| Customer | 20 | 20 |
| Owner | 14 | 14 |
| Admin | 14 | 14 |
| Tổng cộng | 58 | 58 |

Tỷ lệ đạt: 100%.

---

## Kỹ thuật kiểm thử

- Static Review
- White-box Testing
- Black-box Testing
- Boundary Value Analysis
- Equivalence Partitioning
- State Transition Testing
- Role-based Testing

---


## Vai trò hệ thống

- Guest / Public
- Customer
- Owner
- Admin

---

## Hướng dẫn chạy dự án

### Cài đặt thư viện

```bash
composer install
```

### Tạo file môi trường

```bash
copy .env.example .env
```

### Sinh khóa ứng dụng

```bash
php artisan key:generate
```

### Chạy migration

```bash
php artisan migrate
```

### Khởi động server

```bash
php artisan serve
```

Truy cập:

```text
http://127.0.0.1:8000
```

### Đăng nhập Google và gửi email

Ứng dụng dùng Google OAuth với callback:

```text
http://127.0.0.1:8000/auth/google/callback
```

Tạo OAuth Client ID loại **Web application** trong Google Cloud Console, thêm URL trên vào **Authorized redirect URIs**, sau đó đặt `GOOGLE_CLIENT_ID` và `GOOGLE_CLIENT_SECRET` trong `.env`. Nếu ứng dụng OAuth đang ở chế độ kiểm thử, thêm tài khoản Google đăng nhập vào danh sách **Test users**. Không commit các giá trị secret.

Để gửi email thật bằng Gmail:

1. Bật xác minh 2 bước cho tài khoản Gmail và tạo **App Password**. Không dùng mật khẩu đăng nhập Gmail thông thường.
2. Trong `.env`, đặt `MAIL_MAILER=smtp`, `MAIL_SCHEME=smtp`, `MAIL_HOST=smtp.gmail.com`, `MAIL_PORT=587`.
3. Đặt `MAIL_USERNAME` là địa chỉ Gmail, `MAIL_PASSWORD` là App Password và `MAIL_FROM_ADDRESS` bằng địa chỉ Gmail đó.
4. Chạy `php artisan config:clear` sau khi sửa `.env`.

Mặc định Laravel dùng mailer `log`; khi đó email chỉ được ghi vào log, không gửi đến hộp thư. Luồng quên mật khẩu dùng email đặt lại mật khẩu của Laravel; email xác nhận đặt phòng được gửi sau khi thanh toán thành công. Email hủy đơn và lời mời đánh giá cũng đã được nối vào các luồng nghiệp vụ tương ứng.

---

## Tài liệu tham khảo

- ISO/IEC 25010
- Laravel Documentation
- PHPUnit Documentation
- Selenium IDE Documentation
- Tài liệu môn Kiểm định phần mềm
:vv
---

## License

Dự án được thực hiện phục vụ mục đích học tập môn Kiểm định phần mềm.
