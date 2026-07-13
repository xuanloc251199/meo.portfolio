<!DOCTYPE html>
<html lang="vi" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Tạo mã QR miễn phí — Xuan Loc</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Trình tạo mã QR miễn phí: URL, WiFi, vCard, Email, SMS... Tùy chỉnh màu sắc, logo, kiểu chấm và tải về PNG/JPG/WEBP/SVG.">
  <link rel="icon" href="{{ asset('img/favicon/favicon.ico') }}" sizes="any">
  <link rel="icon" href="{{ asset('img/favicon/icon.svg') }}" type="image/svg+xml">
  <!-- Phosphor icon font lives in plugins.css -->
  <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('css/qr.css') }}">
  <script>
    // Apply saved theme before paint to avoid a flash (same key as the portfolio).
    (function () {
      var saved = localStorage.getItem('template.theme');
      var theme = saved || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
      document.documentElement.setAttribute('color-scheme', theme);
    })();
  </script>
</head>
<body class="qrp-body">
  <div class="qrp">

    <header class="qrp__header">
      <div class="qrp__brand">
        <span class="qrp__logo"><i class="ph-bold ph-qr-code"></i></span>
        <span>Tạo mã QR
          <small>miễn phí · tùy chỉnh · tải PNG/JPG/WEBP/SVG</small>
        </span>
      </div>
      <button id="qrp-theme" class="qrp__theme" type="button" aria-label="Đổi giao diện sáng/tối">
        <i class="ph-bold ph-moon-stars"></i>
      </button>
    </header>

    <main class="qrp__main">

      <!-- LEFT: content + design -->
      <div class="qrp__left">

        <!-- Content -->
        <section class="card">
          <h2 class="card__title"><span class="step">1</span> Chọn loại &amp; nhập nội dung</h2>

          <div class="qrp__types" id="qrp-types">
            <button class="type-btn is-active" data-type="url" type="button"><i class="ph-bold ph-link"></i>URL</button>
            <button class="type-btn" data-type="text" type="button"><i class="ph-bold ph-text-t"></i>Văn bản</button>
            <button class="type-btn" data-type="email" type="button"><i class="ph-bold ph-envelope-simple"></i>Email</button>
            <button class="type-btn" data-type="phone" type="button"><i class="ph-bold ph-phone"></i>Điện thoại</button>
            <button class="type-btn" data-type="sms" type="button"><i class="ph-bold ph-chat-text"></i>SMS</button>
            <button class="type-btn" data-type="whatsapp" type="button"><i class="ph-bold ph-whatsapp-logo"></i>WhatsApp</button>
            <button class="type-btn" data-type="wifi" type="button"><i class="ph-bold ph-wifi-high"></i>WiFi</button>
            <button class="type-btn" data-type="vcard" type="button"><i class="ph-bold ph-address-book"></i>Danh thiếp</button>
            <button class="type-btn" data-type="location" type="button"><i class="ph-bold ph-map-pin"></i>Vị trí</button>
            <button class="type-btn" data-type="event" type="button"><i class="ph-bold ph-calendar-check"></i>Sự kiện</button>
          </div>

          <div class="qrp__forms" id="qrp-forms">

            <!-- URL -->
            <div class="qrp__form is-active" data-form="url">
              <div class="field">
                <label for="qr-url">Đường dẫn (URL)</label>
                <input class="input" type="url" id="qr-url" data-field placeholder="https://example.com" value="{{ url('/') }}">
              </div>
            </div>

            <!-- Text -->
            <div class="qrp__form" data-form="text">
              <div class="field">
                <label for="qr-text">Nội dung văn bản</label>
                <textarea class="textarea" id="qr-text" data-field placeholder="Nhập văn bản bất kỳ..."></textarea>
              </div>
            </div>

            <!-- Email -->
            <div class="qrp__form" data-form="email">
              <div class="field">
                <label for="qr-email-to">Email nhận</label>
                <input class="input" type="email" id="qr-email-to" data-field placeholder="name@example.com">
              </div>
              <div class="field">
                <label for="qr-email-subject">Tiêu đề</label>
                <input class="input" type="text" id="qr-email-subject" data-field placeholder="Tiêu đề email">
              </div>
              <div class="field">
                <label for="qr-email-body">Nội dung</label>
                <textarea class="textarea" id="qr-email-body" data-field placeholder="Nội dung email..."></textarea>
              </div>
            </div>

            <!-- Phone -->
            <div class="qrp__form" data-form="phone">
              <div class="field">
                <label for="qr-phone">Số điện thoại</label>
                <input class="input" type="tel" id="qr-phone" data-field placeholder="+84 912 345 678">
              </div>
            </div>

            <!-- SMS -->
            <div class="qrp__form" data-form="sms">
              <div class="field">
                <label for="qr-sms-number">Số điện thoại</label>
                <input class="input" type="tel" id="qr-sms-number" data-field placeholder="+84 912 345 678">
              </div>
              <div class="field">
                <label for="qr-sms-message">Tin nhắn</label>
                <textarea class="textarea" id="qr-sms-message" data-field placeholder="Nội dung tin nhắn..."></textarea>
              </div>
            </div>

            <!-- WhatsApp -->
            <div class="qrp__form" data-form="whatsapp">
              <div class="field">
                <label for="qr-wa-number">Số WhatsApp (mã quốc gia, không dấu +)</label>
                <input class="input" type="tel" id="qr-wa-number" data-field placeholder="84912345678">
              </div>
              <div class="field">
                <label for="qr-wa-message">Tin nhắn sẵn</label>
                <textarea class="textarea" id="qr-wa-message" data-field placeholder="Xin chào..."></textarea>
              </div>
            </div>

            <!-- WiFi -->
            <div class="qrp__form" data-form="wifi">
              <div class="field">
                <label for="qr-wifi-ssid">Tên WiFi (SSID)</label>
                <input class="input" type="text" id="qr-wifi-ssid" data-field placeholder="Tên mạng WiFi">
              </div>
              <div class="field row2">
                <div class="field">
                  <label for="qr-wifi-pass">Mật khẩu</label>
                  <input class="input" type="text" id="qr-wifi-pass" data-field placeholder="Mật khẩu">
                </div>
                <div class="field">
                  <label for="qr-wifi-enc">Bảo mật</label>
                  <select class="select" id="qr-wifi-enc" data-field>
                    <option value="WPA">WPA/WPA2</option>
                    <option value="WEP">WEP</option>
                    <option value="nopass">Không mật khẩu</option>
                  </select>
                </div>
              </div>
              <label class="check">
                <input type="checkbox" id="qr-wifi-hidden" data-field> Mạng ẩn (hidden SSID)
              </label>
            </div>

            <!-- vCard -->
            <div class="qrp__form" data-form="vcard">
              <div class="field row2">
                <div class="field"><label for="qr-vc-first">Họ</label><input class="input" id="qr-vc-first" data-field placeholder="Mai Xuân"></div>
                <div class="field"><label for="qr-vc-last">Tên</label><input class="input" id="qr-vc-last" data-field placeholder="Lộc"></div>
              </div>
              <div class="field row2">
                <div class="field"><label for="qr-vc-phone">Điện thoại</label><input class="input" type="tel" id="qr-vc-phone" data-field placeholder="+84..."></div>
                <div class="field"><label for="qr-vc-email">Email</label><input class="input" type="email" id="qr-vc-email" data-field placeholder="name@example.com"></div>
              </div>
              <div class="field row2">
                <div class="field"><label for="qr-vc-org">Công ty</label><input class="input" id="qr-vc-org" data-field placeholder="Công ty"></div>
                <div class="field"><label for="qr-vc-title">Chức danh</label><input class="input" id="qr-vc-title" data-field placeholder="Chức danh"></div>
              </div>
              <div class="field"><label for="qr-vc-url">Website</label><input class="input" type="url" id="qr-vc-url" data-field placeholder="https://..."></div>
              <div class="field"><label for="qr-vc-addr">Địa chỉ</label><input class="input" id="qr-vc-addr" data-field placeholder="Địa chỉ"></div>
            </div>

            <!-- Location -->
            <div class="qrp__form" data-form="location">
              <div class="field row2">
                <div class="field"><label for="qr-geo-lat">Vĩ độ (latitude)</label><input class="input" id="qr-geo-lat" data-field placeholder="16.0544"></div>
                <div class="field"><label for="qr-geo-lng">Kinh độ (longitude)</label><input class="input" id="qr-geo-lng" data-field placeholder="108.2022"></div>
              </div>
            </div>

            <!-- Event -->
            <div class="qrp__form" data-form="event">
              <div class="field"><label for="qr-ev-title">Tên sự kiện</label><input class="input" id="qr-ev-title" data-field placeholder="Tên sự kiện"></div>
              <div class="field"><label for="qr-ev-loc">Địa điểm</label><input class="input" id="qr-ev-loc" data-field placeholder="Địa điểm"></div>
              <div class="field row2">
                <div class="field"><label for="qr-ev-start">Bắt đầu</label><input class="input" type="datetime-local" id="qr-ev-start" data-field></div>
                <div class="field"><label for="qr-ev-end">Kết thúc</label><input class="input" type="datetime-local" id="qr-ev-end" data-field></div>
              </div>
              <div class="field"><label for="qr-ev-desc">Mô tả</label><textarea class="textarea" id="qr-ev-desc" data-field placeholder="Mô tả sự kiện..."></textarea></div>
            </div>

          </div>
        </section>

        <!-- Design -->
        <section class="card">
          <h2 class="card__title"><span class="step">2</span> Tùy chỉnh giao diện</h2>

          <div class="controls">
            <div class="control">
              <span class="field-label">Màu mã QR</span>
              <div class="color-row">
                <input type="color" id="qr-fg" value="#111111">
                <span class="hex" id="qr-fg-hex">#111111</span>
              </div>
            </div>
            <div class="control">
              <span class="field-label">Màu nền</span>
              <div class="color-row">
                <input type="color" id="qr-bg" value="#ffffff">
                <span class="hex" id="qr-bg-hex">#ffffff</span>
              </div>
              <label class="check"><input type="checkbox" id="qr-transparent"> Nền trong suốt</label>
            </div>

            @php
              // Mini SVG illustrations for each style option (one module shape, tiled 3x3 for dots).
              $dotStyles = [
                'square'         => ['Vuông',     '<rect width="6" height="6"/>'],
                'rounded'        => ['Bo tròn',   '<rect width="6" height="6" rx="1.6"/>'],
                'dots'           => ['Chấm tròn', '<circle cx="3" cy="3" r="3"/>'],
                'classy'         => ['Classy',    '<path d="M0 3A3 3 0 0 1 3 0H6V3A3 3 0 0 1 3 6H0Z"/>'],
                'classy-rounded' => ['Classy bo', '<path d="M0 3A3 3 0 0 1 3 0H4.4A1.6 1.6 0 0 1 6 1.6V3A3 3 0 0 1 3 6H1.6A1.6 1.6 0 0 1 0 4.4Z"/>'],
                'extra-rounded'  => ['Bo nhiều',  '<rect width="6" height="6" rx="2.6"/>'],
              ];
              $cornerSquareStyles = [
                'square'        => ['Vuông',   '<rect x="3.5" y="3.5" width="17" height="17" fill="none" stroke="currentColor" stroke-width="3.5"/>'],
                'extra-rounded' => ['Bo tròn', '<rect x="3.5" y="3.5" width="17" height="17" rx="5.5" fill="none" stroke="currentColor" stroke-width="3.5"/>'],
                'dot'           => ['Tròn',    '<circle cx="12" cy="12" r="8.5" fill="none" stroke="currentColor" stroke-width="3.5"/>'],
              ];
              $cornerDotStyles = [
                'square' => ['Vuông', '<rect x="6.5" y="6.5" width="11" height="11"/>'],
                'dot'    => ['Tròn',  '<circle cx="12" cy="12" r="5.5"/>'],
              ];
            @endphp

            <div class="control full">
              <span class="field-label">Kiểu chấm</span>
              <div class="swatches" id="qr-dot-style">
                @foreach ($dotStyles as $value => [$label, $shape])
                  <button class="swatch{{ $loop->first ? ' is-active' : '' }}" data-value="{{ $value }}" type="button" title="{{ $label }}">
                    <svg viewBox="0 0 22 22" fill="currentColor" aria-hidden="true">
                      @foreach ([0, 8, 16] as $y)
                        @foreach ([0, 8, 16] as $x)
                          <g transform="translate({{ $x }},{{ $y }})">{!! $shape !!}</g>
                        @endforeach
                      @endforeach
                    </svg>
                    <span>{{ $label }}</span>
                  </button>
                @endforeach
              </div>
            </div>
            <div class="control">
              <span class="field-label">Kiểu góc ngoài</span>
              <div class="swatches" id="qr-corner-square">
                @foreach ($cornerSquareStyles as $value => [$label, $shape])
                  <button class="swatch{{ $loop->first ? ' is-active' : '' }}" data-value="{{ $value }}" type="button" title="{{ $label }}">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">{!! $shape !!}</svg>
                    <span>{{ $label }}</span>
                  </button>
                @endforeach
              </div>
            </div>
            <div class="control">
              <span class="field-label">Kiểu góc trong</span>
              <div class="swatches" id="qr-corner-dot">
                @foreach ($cornerDotStyles as $value => [$label, $shape])
                  <button class="swatch{{ $loop->first ? ' is-active' : '' }}" data-value="{{ $value }}" type="button" title="{{ $label }}">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">{!! $shape !!}</svg>
                    <span>{{ $label }}</span>
                  </button>
                @endforeach
              </div>
            </div>
            <div class="control">
              <label class="field-label" for="qr-ecc">Mức sửa lỗi</label>
              <select class="select" id="qr-ecc">
                <option value="L">L — 7%</option>
                <option value="M">M — 15%</option>
                <option value="Q" selected>Q — 25%</option>
                <option value="H">H — 30% (nên dùng khi có logo)</option>
              </select>
            </div>

            <div class="control">
              <label class="field-label" for="qr-size">Cỡ xem trước: <span class="range-val" id="qr-size-val">320px</span></label>
              <input type="range" id="qr-size" min="160" max="1000" step="20" value="320">
            </div>
            <div class="control">
              <label class="field-label" for="qr-margin">Lề (quiet zone): <span class="range-val" id="qr-margin-val">10</span></label>
              <input type="range" id="qr-margin" min="0" max="40" step="2" value="10">
            </div>

            <div class="control full">
              <span class="field-label">Logo ở giữa</span>
              <div class="logo-drop">
                <img id="qr-logo-thumb" class="logo-thumb" alt="">
                <label for="qr-logo"><i class="ph-bold ph-upload-simple"></i> Tải logo lên</label>
                <input type="file" id="qr-logo" accept="image/*">
                <button type="button" class="btn-mini" id="qr-logo-remove">Xóa logo</button>
              </div>
            </div>
            <div class="control">
              <label class="field-label" for="qr-logo-size">Cỡ logo: <span class="range-val" id="qr-logo-size-val">40%</span></label>
              <input type="range" id="qr-logo-size" min="10" max="50" step="5" value="40">
            </div>
            <div class="control">
              <span class="field-label">Tùy chọn logo</span>
              <label class="check"><input type="checkbox" id="qr-hide-bg-dots" checked> Ẩn chấm sau logo</label>
            </div>

            <div class="control full">
              <label class="check"><input type="checkbox" id="qr-frame-enable"> Thêm khung + chữ kêu gọi (CTA)</label>
            </div>
            <div class="control">
              <label class="field-label" for="qr-frame-text">Chữ trên khung</label>
              <input class="input" id="qr-frame-text" value="SCAN ME" maxlength="24">
            </div>
            <div class="control">
              <span class="field-label">Màu khung</span>
              <div class="color-row">
                <input type="color" id="qr-frame-color" value="#aa70e0">
                <span class="hex" id="qr-frame-color-hex">#aa70e0</span>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- RIGHT: preview -->
      <aside class="qrp__right">
        <section class="card">
          <h2 class="card__title"><span class="step">3</span> Xem trước &amp; tải về</h2>
          <div class="preview-box">
            <div class="qr-frame" id="qrp-frame">
              <div id="qrp-canvas"></div>
              <div class="qr-cta" id="qrp-cta">SCAN ME</div>
            </div>
          </div>
          <div class="dl-size">
            <label class="field-label" for="qr-export-size">Kích thước tải về</label>
            <div class="dl-size__row">
              <select class="select" id="qr-export-size">
                <option value="512">512 × 512 px</option>
                <option value="1024">1024 × 1024 px</option>
                <option value="1920" selected>1920 × 1920 px</option>
                <option value="2048">2048 × 2048 px</option>
                <option value="4096">4096 × 4096 px</option>
                <option value="custom">Tùy chỉnh…</option>
              </select>
              <input class="input" type="number" id="qr-export-custom" min="128" max="8192" step="1" value="1920" hidden>
            </div>
          </div>
          <div class="downloads">
            <button class="btn btn--primary" id="qrp-dl-png" type="button"><i class="ph-bold ph-download-simple"></i> PNG</button>
            <button class="btn" id="qrp-dl-jpg" type="button"><i class="ph-bold ph-download-simple"></i> JPG</button>
            <button class="btn" id="qrp-dl-webp" type="button"><i class="ph-bold ph-download-simple"></i> WEBP</button>
            <button class="btn" id="qrp-dl-svg" type="button"><i class="ph-bold ph-download-simple"></i> SVG</button>
          </div>
          <p class="hint">Mã QR được tạo hoàn toàn trên trình duyệt của bạn — không dữ liệu nào được gửi đi.
            Khung CTA chỉ có ở PNG/JPG/WEBP; JPG không hỗ trợ nền trong suốt (sẽ dùng nền trắng).</p>
        </section>
      </aside>

    </main>
  </div>

  <script src="{{ asset('js/vendor/qr-code-styling.js') }}"></script>
  <script src="{{ asset('js/qr.js') }}"></script>
</body>
</html>
