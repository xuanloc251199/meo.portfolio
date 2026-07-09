# Session Log

Lịch sử các phiên làm việc với dự án.

---

## [2026-07-09] — Trình tạo mã QR standalone (trang ẩn)

### Mục tiêu
Bổ sung một trang tạo mã QR đầy đủ chức năng như me-qr.com, **không** nằm trong portfolio (không có link ở nav), chỉ truy cập qua URL trực tiếp.

### Changelog chi tiết theo task

#### Task 1: Route + Controller (trang ẩn)
- **Thay đổi:**
  - `routes/web.php` — thêm `GET /qr` → `QrController@index` (có ghi chú rõ: cố ý không liên kết ở nav).
  - `app/Http/Controllers/QrController.php` — chỉ trả về view (toàn bộ xử lý phía client).
  - View có `<meta robots noindex, nofollow>`.

#### Task 2: Thư viện QR (offline)
- **Thay đổi:** tải `qr-code-styling` (UMD, global `QRCodeStyling`) về `public/js/vendor/qr-code-styling.js` (~52KB) — chạy hoàn toàn offline, không phụ thuộc CDN.

#### Task 3: Giao diện standalone
- **Mô tả:** trang HTML riêng, **không** dùng layout portfolio, nhưng đồng bộ design tokens + dark/light theming.
- **Thay đổi:**
  - `resources/views/qr/index.blade.php` — layout 2 cột (nội dung + tùy chỉnh | xem trước), 10 nút chọn loại, form cho từng loại, controls tùy chỉnh, khung xem trước + nút tải.
  - `public/css/qr.css` — CSS tự chứa, mirror token màu (accent/secondary/base…) theo `[color-scheme]`, dùng Phosphor icons từ `plugins.css`.
  - Theme toggle riêng, dùng chung key `localStorage['template.theme']` + attribute `color-scheme` như portfolio (script inline chống FOUC).

#### Task 4: Logic tạo QR (client-side)
- **Thay đổi:** `public/js/qr.js` (vanilla JS, không phụ thuộc app.js):
  - 10 loại nội dung: URL, Text, Email (mailto), Phone (tel), SMS (SMSTO), WhatsApp (wa.me), WiFi (WIFI:), vCard 3.0, Location (geo:), Event (iCalendar VEVENT) — có escape đúng chuẩn cho WiFi/vCard/iCal.
  - Tùy chỉnh: màu mã/nền, kiểu chấm & góc (square/rounded/dots/classy…), mức sửa lỗi L/M/Q/H, kích thước, lề, logo giữa (tự nâng ECC lên H), khung + chữ CTA.
  - Tải về: PNG (ghép khung qua canvas) và SVG (dùng `getRawData`).

#### Task 5: Kiểm thử + review
- **Kiểm thử (browser):** cả 10 encoder ra chuỗi đúng (đã test WiFi có ký tự đặc biệt `My;Net`/`pa,ss:1` → escape đúng; vCard/iCal escape `;`,`,`; ngày iCal `20260801T090000`); PNG+SVG trả Blob hợp lệ; đổi size → canvas đổi kích thước; bật khung → class `has-frame` + CTA; theme toggle lưu localStorage; **không lỗi console**.
- **Review:** chạy workflow review đa tác nhân (ultracode) nhưng 3 agent đều lỗi API 529 Overloaded → tự review ở main loop thay thế.
- **Bug thật đã sửa:** nút "Sự kiện" dùng icon `ph-calendar-dots` không có trong bản Phosphor đang bundle (render trống) → đổi sang `ph-calendar-check`. Đã verify lại: cả 10 icon nút đều có glyph.

### Vấn đề còn tồn đọng
- SVG download không kèm khung CTA (chỉ PNG có) — giới hạn có chủ đích.
- Chưa test upload logo bằng file thật trên browser (code đã kiểm tra tay); chưa test trên nhiều trình duyệt cũ (`color-mix` cần trình duyệt hiện đại).
- **Chi phí phiên tăng vọt** (~$311) chủ yếu do workflow review bị lỗi 529 retry — cần lưu ý khi dùng ultracode.
- Chưa commit.

### File liên quan
- `routes/web.php`, `app/Http/Controllers/QrController.php`
- `resources/views/qr/index.blade.php`
- `public/css/qr.css`, `public/js/qr.js`, `public/js/vendor/qr-code-styling.js`
- `README.md` (mục "Trình tạo mã QR")

---

## [2026-07-07] — Chuyển dữ liệu hardcode sang database + trang admin Filament

### Mục tiêu
Bỏ toàn bộ dữ liệu hardcode trong controller/view, chuyển sang SQLite, và dựng trang quản trị để chỉnh sửa nội dung không cần sửa code.

### Changelog chi tiết theo task

#### Task 1: Database schema + models + seeder
- **Mô tả:** Tạo 6 bảng cho nội dung site và đổ lại toàn bộ dữ liệu cũ.
- **Thay đổi:**
  - `database/migrations/2026_07_07_000001_create_portfolio_tables.php` — bảng `projects`, `tools`, `services`, `resume_entries`, `achievements`, `settings` (key-value).
  - `app/Models/` — `Project`, `Tool`, `Service`, `ResumeEntry`, `Achievement`, `Setting`; accessor `image_url`/`icon_url` hỗ trợ cả ảnh trong `public/img` lẫn ảnh upload trong `storage`.
  - `database/seeders/PortfolioSeeder.php` — seed 30 projects, 11 tools, 5 services, 8 resume entries, 3 achievements, 17 settings (headline, tên, SĐT, email, location, CV, social links…).
  - `database/seeders/DatabaseSeeder.php` — tạo user admin `maixuanloc0101@gmail.com` (mật khẩu `meo-admin-2026`).
  - Ảnh copy từ `public/img/{works,services,icons,avatars}` sang `storage/app/public/` để admin quản lý upload thống nhất; đường dẫn trong DB dạng `works/x.png`.
- **Ghi chú:** DB là SQLite (`database/database.sqlite`). Chạy lại từ đầu: `php artisan migrate:fresh --seed`.

#### Task 2: Frontend đọc từ database
- **Mô tả:** HomeController query models thay vì mảng hardcode; các blade section render bằng vòng lặp/biến settings.
- **Thay đổi:**
  - `app/Http/Controllers/HomeController.php` — truyền `projects, tools, services, education, experience, achievements, settings`.
  - `sections/portfolio.blade.php`, `resume.blade.php` (education/experience/tools), `about.blade.php` (achievements/services/thông tin cá nhân) — loop từ DB.
  - `sections/intro.blade.php`, `contact.blade.php`, `partials/avatar.blade.php`, `partials/header.blade.php` — đọc từ `$settings` (headline, CV, social, phone/email/location, avatar).
  - Settings chứa HTML (`<br>`) render bằng `{!! !!}`: `headline_title`, `logo_caption`, `specialization`, `based_in`.

#### Task 3: Trang admin Filament
- **Mô tả:** Cài `filament/filament` (v4), panel tại `/admin`.
- **Thay đổi:**
  - `app/Providers/Filament/AdminPanelProvider.php` — panel mặc định.
  - `app/Filament/Resources/{Projects,Tools,Services,ResumeEntries,Achievements,Settings}/` — 6 resource CRUD (generate rồi tinh chỉnh): FileUpload cho ảnh (disk `public`, thư mục `works/services/icons`), TagsInput cho tags, Select cho loại resume, bảng có `defaultSort('sort_order')` + kéo-thả `reorderable('sort_order')`.
  - `app/Models/User.php` — implement `FilamentUser` (`canAccessPanel` = true) để đăng nhập được khi deploy production.
- **Ghi chú:** Đăng nhập `/admin` bằng user seed ở Task 1; nên đổi mật khẩu sau lần đăng nhập đầu.

#### Task 4: Kiểm thử
- `GET /` 200 — 30 projects, 11 tools, 3 achievements, 8 resume entries, ảnh trỏ `storage/...`, headline/avatar/email/social render từ settings.
- `GET /admin/login` 200.

#### Task 5: Tags thành danh mục quản lý được (không tự gõ)
- **Mô tả:** Bỏ cột JSON `tags` trên `projects`/`services`, chuyển sang bảng `tags` + pivot nhiều-nhiều; form admin chọn tag từ danh sách.
- **Thay đổi:**
  - `database/migrations/2026_07_07_000002_create_tags_tables.php` — bảng `tags` (name unique), pivot `project_tag`, `service_tag` (cascade delete).
  - `2026_07_07_000001_create_portfolio_tables.php` — bỏ cột json `tags` ở `projects` và `services`.
  - `app/Models/Tag.php` mới; `Project`/`Service` thêm quan hệ `tags()` BelongsToMany, bỏ cast array.
  - `PortfolioSeeder` — helper `syncTags()` tạo tag bằng `firstOrCreate` và attach (seed ra 38 tags).
  - `ProjectForm`/`ServiceForm` — `TagsInput` → `Select->relationship('tags','name')->multiple()->preload()->searchable()`.
  - `app/Filament/Resources/Tags/` — resource CRUD quản lý tags.
  - `portfolio.blade.php`, `about.blade.php` — `{{ $tag }}` → `{{ $tag->name }}`; `HomeController` eager load `with('tags')`.
- **Kiểm thử:** `migrate:fresh --seed` OK; project đầu có tags `Logo Brand, Design`; trang chủ render đủ 79 tag span.

#### Task 6: Dọn tag trùng lặp / sai chính tả
- **Mô tả:** Gộp các tag trùng (khác hoa thường) và sửa lỗi chính tả, còn 35 tags.
- **Thay đổi:**
  - `database/scripts/clean_tags.php` — script gộp tag (chuyển pivot rows sang tag đích, xóa tag nguồn, dọn tag mồ côi); chạy bằng `php artisan tinker database/scripts/clean_tags.php`.
  - Các phép gộp: `Edit video`+`Edit Video`→`Edit Video`; `Recap Event`→`Recap`; `Brand Indentify`→`Brand Identity`; `Event Indentify`→`Event Identity`; `Shoppe`→`Shopee`; `F&b`→`F&B`; `Tiktok Video`→`TikTok Video`; `SM`→`Social Media`; `2D Graphic`→`2D Design`.
  - `PortfolioSeeder` — cập nhật tên tag + sửa typo trong description (`Shoppe`→`Shopee`, `Indentify`→`Identity`) để seed lại vẫn sạch.
- **Kiểm thử:** DB còn 35 tags, trang chủ 200 không còn chuỗi `Indentify`/`Shoppe`.

#### Task 7: Tag chia 2 loại — Định dạng và Hạng mục
- **Mô tả:** Thêm cột `type` cho tags (`format` = Định dạng - loại sản phẩm; `category` = Hạng mục - lĩnh vực), phân loại sẵn 16 format + 19 category.
- **Thay đổi:**
  - Migration `create_tags_tables` — thêm cột `type` (default `category`).
  - `app/Models/Tag.php` — hằng `TYPE_FORMAT`/`TYPE_CATEGORY`, map `TYPE_LABELS`, accessor `type_label`.
  - `PortfolioSeeder::seedTags()` — khai báo type cho toàn bộ 35 tags.
  - Admin `TagForm` — thêm Select "Loại" + unique cho name; `TagsTable` — cột badge "Loại" (xanh dương = Định dạng, xanh lá = Hạng mục) + filter theo loại.
  - `ProjectForm`/`ServiceForm` — dropdown tag hiển thị prefix `[Định dạng]`/`[Hạng mục]`, sắp theo loại rồi tên.
- **Kiểm thử:** `migrate:fresh --seed` OK (16 format / 19 category); trang chủ và `/admin/login` đều 200.

#### Task 8: Tinh gọn bộ tag + fix bị logout khi sửa trong admin
- **Mô tả:** Gộp/đổi tên tag cho gọn (còn 31: 13 Định dạng + 18 Hạng mục); sửa lỗi admin bị đăng xuất giữa chừng khi sửa.
- **Thay đổi:**
  - `PortfolioSeeder` — gộp: `Design`→`2D Design`, `Edit Video`→`Video`, `Foody`→`F&B`, `Ads Poster`+`Brand Poster`→`Poster`; đổi tên: `Logo Brand`→`Logo`, `Brand Menu`→`Menu`, `Profile Design`→`Company Profile`, `Illustrations`→`Illustration`, `Web Develop`→`Web Development`, `App Develop`→`App Development`.
  - `.env` + `.env.example` — `SESSION_DRIVER=database`→`file`, `SESSION_LIFETIME=120`→`720`.
- **Ghi chú:** Nguyên nhân logout: session lưu ở bảng `sessions` trong DB, mỗi lần `migrate:fresh` là mất phiên → Livewire trả 419 → văng ra login. Chuyển sang file driver thì phiên đăng nhập sống sót qua các lần reset DB, lifetime 12h.
- **Kiểm thử:** 31 tags đúng danh sách, không tag lạ; trang chủ + `/admin/login` 200.

#### Task 9: Album ảnh + loại dự án (web/app/UX-UI) + bộ lọc portfolio
- **Mô tả:** Project có thể chứa album nhiều ảnh (mở lightbox); thêm trường loại dự án; portfolio có thanh lọc theo loại, giữ nguyên phong cách giao diện.
- **Thay đổi:**
  - Migration `2026_07_07_000003_add_type_and_images_to_projects.php` — cột `type` (design/photography/video/web/app/uiux) và `images` (json, danh sách ảnh album trong storage).
  - `app/Models/Project.php` — `TYPE_LABELS`, accessor `type_label`, `album_items` (slide PhotoSwipe: ảnh chính + album; ảnh album w/h=0 để client tự đo).
  - `PortfolioSeeder` — gán loại cho 30 project cũ; thêm project #31 "Meo Portfolio Website" (type web, ảnh `img/demo/mockup.webp`, tags Web Development + UI/UX Design).
  - `sections/portfolio.blade.php` — thanh lọc chip (All + các loại đang có) dùng style `rounded-tag tag-outline`, active nền `var(--accent)`; figure thêm `data-type`, `data-album`; ảnh grid thêm `loading="lazy"`.
  - `public/js/gallery-init.js` — viết lại: mỗi card mở PhotoSwipe album riêng (trước đây tất cả card chung 1 gallery); tự đo kích thước ảnh album khi load; logic lọc theo loại + `ScrollTrigger.refresh()`.
  - Admin `ProjectForm` — Select "Loại dự án" + FileUpload nhiều ảnh (kéo thả đổi thứ tự, lưu `works/albums`); `ProjectsTable` — cột badge Loại.
- **Kiểm thử (browser):** lọc Photography còn 7 card hiển thị; bấm card mở PhotoSwipe (`pswp--open`); card web xuất hiện; nút lọc active đúng màu accent (46×34px). Ghi chú: tool chụp screenshot preview bị treo nhưng trang phản hồi bình thường, không lỗi console.

#### Task 10: Bộ lọc thứ hai (Hạng mục) + link Detail cho project web
- **Mô tả:** Portfolio có 2 hàng lọc kết hợp AND: "Loại dự án" và "Hạng mục" (tag type category); project "Meo Portfolio Website" có link Detail (GitHub repo).
- **Thay đổi:**
  - `sections/portfolio.blade.php` — 2 hàng chip có nhãn "Loại dự án"/"Hạng mục" (`data-filter-group="type|tag"`); hàng Hạng mục lấy động các tag category đang dùng bởi project; figure thêm `data-tags` (tên tags).
  - `public/js/gallery-init.js` — filter state `{type, tag}` kết hợp cả 2 nhóm.
  - `PortfolioSeeder` + DB — link project web = https://github.com/xuanloc251199/meo.portfolio.
- **Kiểm thử (browser):** 5 nút loại + 11 nút hạng mục; Photography+F&B = 3 card; Photography = 7; All = 31; card web có nút Detail trỏ GitHub.

### Vấn đề còn tồn đọng
- Mật khẩu admin đang là giá trị seed mặc định — cần đổi.
- Chưa test đăng nhập admin bằng browser thật (chỉ smoke-test HTTP).
- Chưa commit.

### File liên quan
- `database/migrations/2026_07_07_000001_create_portfolio_tables.php`, `database/seeders/PortfolioSeeder.php`
- `app/Models/`, `app/Filament/Resources/`, `app/Providers/Filament/AdminPanelProvider.php`
- `app/Http/Controllers/HomeController.php`, `resources/views/`

---

## [2026-07-07] — Chuyển toàn bộ site tĩnh sang Laravel 12

### Mục tiêu
Chuyển website portfolio từ HTML tĩnh (index.html + mail.php) sang framework Laravel hoàn chỉnh, giữ nguyên 100% giao diện và hành vi.

### Changelog chi tiết theo task

#### Task 1: Dựng khung Laravel 12
- **Mô tả:** Tạo project Laravel mới bằng `composer create-project laravel/laravel` rồi chuyển toàn bộ vào gốc repo.
- **Thay đổi:**
  - Thêm toàn bộ khung Laravel: `app/`, `bootstrap/`, `config/`, `database/`, `routes/`, `resources/`, `storage/`, `tests/`, `artisan`, `composer.json`, `.env`, v.v.
  - `css/`, `fonts/`, `img/`, `js/` — chuyển vào `public/`.
  - `.htaccess` (gốc) — viết lại để rewrite mọi request vào `public/` (phục vụ Apache/Laragon và shared hosting).
  - `.env` — đặt `APP_NAME="Xuan Loc Portfolio"`, thêm `CONTACT_TO`.
- **Ghi chú:** DB dùng SQLite mặc định (`database/database.sqlite`), hiện chưa có model nào cần DB.

#### Task 2: Tách index.html thành Blade views
- **Mô tả:** Chia file `index.html` 1577 dòng thành layout + partials + sections, mọi đường dẫn asset dùng helper `asset()`.
- **Thay đổi:**
  - `resources/views/layouts/app.blade.php` — head, meta (thêm `csrf-token`), scripts.
  - `resources/views/partials/header.blade.php`, `partials/avatar.blade.php`, `partials/photoswipe.blade.php`.
  - `resources/views/sections/intro.blade.php`, `about.blade.php`, `resume.blade.php`, `contact.blade.php` — giữ nguyên HTML gốc.
  - `resources/views/sections/portfolio.blade.php` — render 30 project card bằng vòng lặp `@foreach`.
  - `resources/views/sections/resume.blade.php` — danh sách tools render bằng vòng lặp.
  - `resources/views/home.blade.php` — ghép các section.
  - Xóa `index.html`, `resources/views/welcome.blade.php`.
- **Ghi chú:** Dữ liệu 30 project + 11 tool được đưa vào `HomeController` — thêm project mới chỉ cần thêm phần tử mảng, không sửa HTML.

#### Task 3: Chuyển mail.php sang Controller + Mailable
- **Mô tả:** Thay script `mail.php` cũ (dùng `mail()` thô, cho phép client tự quyết định email người nhận — lỗ hổng bảo mật) bằng luồng Laravel chuẩn.
- **Thay đổi:**
  - `routes/web.php` — `GET /` → `HomeController@index`, `POST /contact` → `ContactController@send`.
  - `app/Http/Controllers/ContactController.php` — validate (name, company, email, phone, message) và gửi mail.
  - `app/Mail/ContactMessage.php` + `resources/views/emails/contact.blade.php` — email dạng bảng như bản cũ, `Reply-To` là email người gửi.
  - `config/portfolio.php` — key `contact_to` đọc từ env `CONTACT_TO`; người nhận cố định phía server, bỏ các hidden field `admin_email`/`project_name`/`form_subject`.
  - `resources/views/sections/contact.blade.php` — form thêm `@csrf`, `action="{{ route('contact.send') }}"`, đổi tên field sang chữ thường.
  - `public/js/app.js` — AJAX submit đổi từ `url: "mail.php"` sang `url: th.attr("action")` (token CSRF được serialize kèm form).
  - Xóa `mail.php`.
- **Ghi chú:** Mặc định `MAIL_MAILER=log` — mail ghi vào `storage/logs/laravel.log`; khi deploy cần cấu hình SMTP thật.

#### Task 4: Kiểm thử
- **Mô tả:** Chạy `php artisan serve` và smoke-test.
- **Kết quả:**
  - `GET /` trả 200, đủ 30 gallery item + 11 tool item, có csrf-token.
  - `POST /contact` với token hợp lệ trả `{"ok":true}`, mail xuất hiện trong log với đúng subject/reply-to/nội dung.

### Vấn đề còn tồn đọng
- Chưa cấu hình SMTP thật (đang dùng log driver).
- `source-files/` giữ nguyên ở gốc repo làm tài liệu tham khảo; có thể xóa nếu không cần.
- Chưa commit — toàn bộ thay đổi đang ở working tree.

### File liên quan
- `routes/web.php`
- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/ContactController.php`
- `app/Mail/ContactMessage.php`
- `resources/views/` (toàn bộ)
- `config/portfolio.php`
- `public/js/app.js`
- `.htaccess`, `.env.example`
