/* ==========================================================================
   QR Code Generator — page logic (vanilla JS, no jQuery).
   Uses the vendored qr-code-styling library (global: QRCodeStyling).
   All generation, customisation and downloads happen client-side.
   ========================================================================== */
(function () {
  'use strict';

  if (typeof QRCodeStyling === 'undefined') {
    console.error('qr-code-styling failed to load.');
    return;
  }

  var $ = function (id) { return document.getElementById(id); };

  // ---- Theme toggle (mirrors the portfolio: color-scheme attr + localStorage) ----
  var themeBtn = $('qrp-theme');
  function currentTheme() {
    return document.documentElement.getAttribute('color-scheme') ||
      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  }
  function paintThemeIcon(theme) {
    themeBtn.innerHTML = theme === 'light'
      ? '<i class="ph-bold ph-moon-stars"></i>'
      : '<i class="ph-bold ph-sun"></i>';
  }
  paintThemeIcon(currentTheme());
  themeBtn.addEventListener('click', function () {
    var theme = currentTheme() === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('color-scheme', theme);
    localStorage.setItem('template.theme', theme);
    paintThemeIcon(theme);
  });

  // ---- Encoding helpers ------------------------------------------------------
  function enc(s) { return encodeURIComponent(s || ''); }

  // Escape special chars for WiFi / MECARD style strings: \ ; , : "
  function escSpecial(s) {
    return String(s || '').replace(/([\\;,:"])/g, '\\$1');
  }
  // Escape for vCard / iCalendar text values: \ ; , and newlines
  function escVCard(s) {
    return String(s || '')
      .replace(/\\/g, '\\\\')
      .replace(/\n/g, '\\n')
      .replace(/;/g, '\\;')
      .replace(/,/g, '\\,');
  }
  // "2026-07-09T14:30" -> "20260709T143000" (floating local time, no Z)
  function icalDate(v) {
    if (!v) return '';
    var m = /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})/.exec(v);
    if (!m) return '';
    return m[1] + m[2] + m[3] + 'T' + m[4] + m[5] + '00';
  }
  function val(id) { var el = $(id); return el ? el.value.trim() : ''; }

  // ---- Build the QR data string from the active content type -----------------
  function buildData() {
    switch (state.type) {
      case 'url': {
        return val('qr-url');
      }
      case 'text': {
        return val('qr-text');
      }
      case 'email': {
        var to = val('qr-email-to');
        var sub = val('qr-email-subject');
        var body = val('qr-email-body');
        if (!to && !sub && !body) return '';
        var q = [];
        if (sub) q.push('subject=' + enc(sub));
        if (body) q.push('body=' + enc(body));
        return 'mailto:' + to + (q.length ? '?' + q.join('&') : '');
      }
      case 'phone': {
        var p = val('qr-phone');
        return p ? 'tel:' + p.replace(/\s+/g, '') : '';
      }
      case 'sms': {
        var num = val('qr-sms-number').replace(/\s+/g, '');
        var msg = val('qr-sms-message');
        if (!num && !msg) return '';
        return 'SMSTO:' + num + ':' + msg;
      }
      case 'whatsapp': {
        var wn = val('qr-wa-number').replace(/[^\d]/g, '');
        var wm = val('qr-wa-message');
        if (!wn) return '';
        return 'https://wa.me/' + wn + (wm ? '?text=' + enc(wm) : '');
      }
      case 'wifi': {
        var ssid = val('qr-wifi-ssid');
        if (!ssid) return '';
        var pass = val('qr-wifi-pass');
        var encType = val('qr-wifi-enc') || 'WPA';
        var hidden = $('qr-wifi-hidden').checked;
        var s = 'WIFI:T:' + encType + ';S:' + escSpecial(ssid) + ';';
        if (encType !== 'nopass') s += 'P:' + escSpecial(pass) + ';';
        if (hidden) s += 'H:true;';
        return s + ';';
      }
      case 'vcard': {
        var first = val('qr-vc-first'), last = val('qr-vc-last');
        var phone = val('qr-vc-phone'), email = val('qr-vc-email');
        var org = val('qr-vc-org'), title = val('qr-vc-title');
        var url = val('qr-vc-url'), addr = val('qr-vc-addr');
        if (!(first || last || phone || email || org)) return '';
        var lines = ['BEGIN:VCARD', 'VERSION:3.0'];
        lines.push('N:' + escVCard(last) + ';' + escVCard(first) + ';;;');
        lines.push('FN:' + escVCard((first + ' ' + last).trim()));
        if (org) lines.push('ORG:' + escVCard(org));
        if (title) lines.push('TITLE:' + escVCard(title));
        if (phone) lines.push('TEL;TYPE=CELL:' + escVCard(phone));
        if (email) lines.push('EMAIL:' + escVCard(email));
        if (url) lines.push('URL:' + escVCard(url));
        if (addr) lines.push('ADR:;;' + escVCard(addr) + ';;;;');
        lines.push('END:VCARD');
        return lines.join('\n');
      }
      case 'location': {
        var lat = val('qr-geo-lat'), lng = val('qr-geo-lng');
        if (!lat || !lng) return '';
        return 'geo:' + lat + ',' + lng;
      }
      case 'event': {
        var t = val('qr-ev-title');
        if (!t) return '';
        var loc = val('qr-ev-loc');
        var start = icalDate(val('qr-ev-start'));
        var end = icalDate(val('qr-ev-end'));
        var desc = val('qr-ev-desc');
        var ev = ['BEGIN:VCALENDAR', 'VERSION:2.0', 'BEGIN:VEVENT'];
        ev.push('SUMMARY:' + escVCard(t));
        if (loc) ev.push('LOCATION:' + escVCard(loc));
        if (desc) ev.push('DESCRIPTION:' + escVCard(desc));
        if (start) ev.push('DTSTART:' + start);
        if (end) ev.push('DTEND:' + end);
        ev.push('END:VEVENT', 'END:VCALENDAR');
        return ev.join('\n');
      }
      default:
        return '';
    }
  }

  // ---- State -----------------------------------------------------------------
  var state = { type: 'url', logo: '' };
  var PLACEHOLDER = 'https://'; // keeps the library happy when inputs are empty

  // ---- QR instance -----------------------------------------------------------
  var qr = new QRCodeStyling({
    width: 320,
    height: 320,
    type: 'canvas',
    data: PLACEHOLDER,
    margin: 10,
    qrOptions: { errorCorrectionLevel: 'Q' },
    dotsOptions: { color: '#111111', type: 'square' },
    backgroundOptions: { color: '#ffffff' },
    cornersSquareOptions: { color: '#111111', type: 'square' },
    cornersDotOptions: { color: '#111111', type: 'square' },
    imageOptions: { hideBackgroundDots: true, imageSize: 0.4, margin: 6, crossOrigin: 'anonymous' }
  });
  qr.append($('qrp-canvas'));

  // ---- Read all options from the UI and re-render ----------------------------
  var renderTimer = null;
  function scheduleRender() {
    clearTimeout(renderTimer);
    renderTimer = setTimeout(render, 120);
  }

  function currentSize() {
    return parseInt($('qr-size').value, 10) || 320;
  }

  function render() {
    var data = buildData();
    var size = currentSize();
    var opts = {
      width: size,
      height: size,
      data: data || PLACEHOLDER,
      margin: parseInt($('qr-margin').value, 10) || 0,
      qrOptions: { errorCorrectionLevel: $('qr-ecc').value },
      dotsOptions: { color: $('qr-fg').value, type: $('qr-dot-style').value },
      backgroundOptions: { color: $('qr-bg').value },
      cornersSquareOptions: { color: $('qr-fg').value, type: $('qr-corner-square').value },
      cornersDotOptions: { color: $('qr-fg').value, type: $('qr-corner-dot').value },
      image: state.logo || undefined,
      imageOptions: {
        hideBackgroundDots: $('qr-hide-bg-dots').checked,
        imageSize: (parseInt($('qr-logo-size').value, 10) || 40) / 100,
        margin: 6,
        crossOrigin: 'anonymous'
      }
    };
    qr.update(opts);
    updateFrame();
  }

  // ---- Frame (CTA) -----------------------------------------------------------
  function updateFrame() {
    var on = $('qr-frame-enable').checked;
    var frame = $('qrp-frame');
    var cta = $('qrp-cta');
    frame.classList.toggle('has-frame', on);
    frame.style.borderColor = $('qr-frame-color').value;
    frame.style.background = $('qr-bg').value;
    cta.style.background = $('qr-frame-color').value;
    cta.textContent = $('qr-frame-text').value || 'SCAN ME';
  }

  // ---- Type switching --------------------------------------------------------
  document.querySelectorAll('#qrp-types .type-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('#qrp-types .type-btn').forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      state.type = btn.getAttribute('data-type');
      document.querySelectorAll('.qrp__form').forEach(function (f) {
        f.classList.toggle('is-active', f.getAttribute('data-form') === state.type);
      });
      render();
    });
  });

  // ---- Wire up every input to re-render --------------------------------------
  document.querySelectorAll('[data-field]').forEach(function (el) {
    var evt = (el.type === 'checkbox' || el.tagName === 'SELECT') ? 'change' : 'input';
    el.addEventListener(evt, scheduleRender);
  });

  // Design controls
  ['qr-dot-style', 'qr-corner-square', 'qr-corner-dot', 'qr-ecc', 'qr-hide-bg-dots']
    .forEach(function (id) { $(id).addEventListener('change', render); });

  function bindColor(id, hexId, extra) {
    var input = $(id), hex = $(hexId);
    input.addEventListener('input', function () {
      hex.textContent = input.value;
      if (extra) extra();
      render();
    });
    hex.textContent = input.value;
  }
  bindColor('qr-fg', 'qr-fg-hex');
  bindColor('qr-bg', 'qr-bg-hex');
  bindColor('qr-frame-color', 'qr-frame-color-hex', updateFrame);

  $('qr-size').addEventListener('input', function () {
    $('qr-size-val').textContent = this.value + 'px';
    scheduleRender();
  });
  $('qr-margin').addEventListener('input', function () {
    $('qr-margin-val').textContent = this.value;
    scheduleRender();
  });
  $('qr-logo-size').addEventListener('input', function () {
    $('qr-logo-size-val').textContent = this.value + '%';
    scheduleRender();
  });

  ['qr-frame-enable', 'qr-frame-text', 'qr-frame-color'].forEach(function (id) {
    var el = $(id);
    el.addEventListener(el.type === 'checkbox' ? 'change' : 'input', updateFrame);
  });

  // ---- Logo upload -----------------------------------------------------------
  $('qr-logo').addEventListener('change', function (e) {
    var file = e.target.files && e.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (ev) {
      state.logo = ev.target.result;
      var thumb = $('qr-logo-thumb');
      thumb.src = state.logo;
      thumb.style.display = 'block';
      $('qr-logo-remove').style.display = 'inline';
      // A logo covers part of the QR — bump error correction so it stays scannable.
      $('qr-ecc').value = 'H';
      render();
    };
    reader.readAsDataURL(file);
  });
  $('qr-logo-remove').addEventListener('click', function () {
    state.logo = '';
    $('qr-logo').value = '';
    $('qr-logo-thumb').style.display = 'none';
    this.style.display = 'none';
    render();
  });

  // ---- Downloads -------------------------------------------------------------
  function triggerBlobDownload(blob, filename) {
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
  }

  function loadImage(src) {
    return new Promise(function (resolve, reject) {
      var img = new Image();
      img.onload = function () { resolve(img); };
      img.onerror = reject;
      img.src = src;
    });
  }

  // Compose the QR (as a PNG blob) onto a canvas, optionally with the CTA frame.
  async function downloadPng() {
    try {
      var raw = await qr.getRawData('png');
      var blob = (raw instanceof Blob) ? raw : new Blob([raw], { type: 'image/png' });
      var img = await loadImage(URL.createObjectURL(blob));

      var frameOn = $('qr-frame-enable').checked;
      var border = frameOn ? Math.round(img.width * 0.06) : 0;
      var labelH = frameOn ? Math.round(img.width * 0.16) : 0;

      var canvas = document.createElement('canvas');
      canvas.width = img.width + border * 2;
      canvas.height = img.height + border * 2 + labelH;
      var ctx = canvas.getContext('2d');

      // Frame / background fill.
      ctx.fillStyle = frameOn ? $('qr-frame-color').value : $('qr-bg').value;
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      // QR background inside the border.
      ctx.fillStyle = $('qr-bg').value;
      ctx.fillRect(border, border, img.width, img.height);
      ctx.drawImage(img, border, border, img.width, img.height);

      if (frameOn) {
        ctx.fillStyle = $('qr-frame-color').value;
        ctx.fillRect(0, img.height + border * 2, canvas.width, labelH);
        ctx.fillStyle = '#14141a';
        ctx.font = '700 ' + Math.round(labelH * 0.42) + 'px Poppins, Segoe UI, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        var text = ($('qr-frame-text').value || 'SCAN ME').toUpperCase();
        ctx.fillText(text, canvas.width / 2, img.height + border * 2 + labelH / 2);
      }

      canvas.toBlob(function (out) { triggerBlobDownload(out, 'qr-code.png'); }, 'image/png');
    } catch (err) {
      console.error(err);
      // Fallback: let the library handle the download directly.
      qr.download({ name: 'qr-code', extension: 'png' });
    }
  }

  $('qrp-dl-png').addEventListener('click', downloadPng);
  $('qrp-dl-svg').addEventListener('click', function () {
    qr.download({ name: 'qr-code', extension: 'svg' });
  });

  // ---- First paint -----------------------------------------------------------
  render();
})();
