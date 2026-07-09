# Meo Portfolio (Laravel)

Website portfolio cá nhân của Mai Xuân Lộc (template Braxton), đã được chuyển từ HTML tĩnh sang **Laravel 12**.

## Yêu cầu

- PHP >= 8.2
- Composer

## Cài đặt & chạy

```bash
composer install
cp .env.example .env        # Windows: copy .env.example .env
php artisan key:generate
php artisan migrate --seed  # tạo DB (SQLite) + đổ dữ liệu portfolio
php artisan storage:link
php artisan serve
```

Hoặc chạy qua Laragon: truy cập `http://meo.portfolio.test` (file `.htaccess` ở gốc đã rewrite vào `public/`).

## Trang quản trị (Filament)

- URL: `/admin` — đăng nhập bằng `maixuanloc0101@gmail.com` / `meo-admin-2026` (**đổi mật khẩu sau khi đăng nhập lần đầu**).
- Quản lý được: **Projects** (portfolio — có loại dự án design/photography/video/web/app/uiux và **album nhiều ảnh**), **Tags** (chia Định dạng / Hạng mục), **Tools**, **Services**, **Resume entries** (education/experience), **Achievements**, **Settings** (tên, headline, SĐT, email, link CV, mạng xã hội…).
- Các bảng hỗ trợ kéo-thả để đổi thứ tự hiển thị; ảnh upload lưu vào `storage/app/public` (cần `php artisan storage:link`).

## Cấu trúc chính

- `routes/web.php` — 2 route: `GET /` (trang chủ) và `POST /contact` (gửi form liên hệ).
- `app/Http/Controllers/HomeController.php` — đọc toàn bộ nội dung từ database (models: `Project`, `Tool`, `Service`, `ResumeEntry`, `Achievement`, `Setting`).
- `database/seeders/PortfolioSeeder.php` — dữ liệu gốc của site; chạy `php artisan db:seed` để khôi phục.
- `app/Filament/Resources/` — các màn hình CRUD của trang admin.
- `app/Http/Controllers/ContactController.php` + `app/Mail/ContactMessage.php` — xử lý form liên hệ (validate + gửi mail).
- `resources/views/` — Blade views:
  - `layouts/app.blade.php` — layout chung (head, scripts)
  - `partials/` — header, avatar, photoswipe
  - `sections/` — intro, portfolio, about, resume, contact
  - `emails/contact.blade.php` — template email liên hệ
- `public/css`, `public/js`, `public/img`, `public/fonts` — assets của template gốc.
- `source-files/` — mã nguồn gốc các thư viện JS của template (tham khảo, không được serve).

## Trình tạo mã QR (trang ẩn)

- URL: `/qr` — **không** được liên kết ở đâu trong portfolio, chỉ truy cập qua link trực tiếp (có `meta robots noindex`).
- Tạo mã QR hoàn toàn phía client (thư viện `public/js/vendor/qr-code-styling.js`), không gửi dữ liệu về server.
- Hỗ trợ: URL, Văn bản, Email, Điện thoại, SMS, WhatsApp, WiFi, Danh thiếp (vCard), Vị trí, Sự kiện.
- Tùy chỉnh: màu mã/nền, kiểu chấm & góc, mức sửa lỗi, kích thước, lề, logo ở giữa, khung + chữ CTA.
- Tải về: PNG (kèm khung nếu bật) và SVG.
- Giao diện dùng chung design tokens + dark/light theming với portfolio (`public/css/qr.css` + Phosphor icons từ `plugins.css`).

## Cấu hình mail

Mặc định `.env` dùng `MAIL_MAILER=log` (mail ghi vào `storage/logs/laravel.log`). Khi deploy, đổi sang SMTP thật và chỉnh:

- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`
- `CONTACT_TO` — email nhận tin nhắn từ form liên hệ (mặc định `maixuanloc0101@gmail.com`).

## Lịch sử phiên làm việc

Xem [SESSIONS.md](./SESSIONS.md) để biết chi tiết các thay đổi qua từng phiên.
