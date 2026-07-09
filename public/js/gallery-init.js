// ------------------------------------------------
// File name: gallery-init.js
// Per-project PhotoSwipe albums + portfolio type filter.
// Each .gallery__item carries its slides in data-album
// (main image first, then album images uploaded via admin).
// ------------------------------------------------

var initAlbumGalleries = function (gallerySelector) {

  var pswpElement = document.querySelectorAll('.pswp')[0];

  var openAlbum = function (figure) {
    var items;

    try {
      items = JSON.parse(figure.getAttribute('data-album')) || [];
    } catch (e) {
      items = [];
    }

    if (!items.length || !pswpElement) {
      return;
    }

    var thumbnail = figure.getElementsByTagName('img')[0];

    if (thumbnail && items[0]) {
      items[0].msrc = thumbnail.getAttribute('src');
    }

    var options = {
      index: 0,
      showHideOpacity: true,
      getThumbBoundsFn: function () {
        var pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
            rect = thumbnail.getBoundingClientRect();

        return { x: rect.left, y: rect.top + pageYScroll, w: rect.width };
      }
    };

    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

    // Album images uploaded via admin have unknown dimensions (w/h = 0):
    // load the real size once, then refresh the current slide.
    gallery.listen('gettingData', function (index, item) {
      if (item.w < 1 || item.h < 1) {
        var img = new Image();
        img.onload = function () {
          item.w = this.width;
          item.h = this.height;
          gallery.invalidateCurrItems();
          gallery.updateSize(true);
        };
        img.src = item.src;
      }
    });

    gallery.init();
  };

  document.querySelectorAll(gallerySelector + ' .gallery__item').forEach(function (figure) {
    var link = figure.querySelector('.gallery__link');

    if (!link) {
      return;
    }

    link.addEventListener('click', function (e) {
      e.preventDefault();
      openAlbum(figure);
    });
  });
};

var initPortfolioFilter = function () {
  var groups = document.querySelectorAll('.portfolio-filter [data-filter-group]');

  if (!groups.length) {
    return;
  }

  var state = { type: 'all', tag: 'all' };

  var applyFilters = function () {
    document.querySelectorAll('.my-gallery .gallery__item').forEach(function (item) {
      var okType = state.type === 'all' || item.getAttribute('data-type') === state.type;

      var tags = [];
      try {
        tags = JSON.parse(item.getAttribute('data-tags')) || [];
      } catch (e) {
        tags = [];
      }
      var okTag = state.tag === 'all' || tags.indexOf(state.tag) !== -1;

      item.style.display = (okType && okTag) ? '' : 'none';
    });

    // Re-run scroll-triggered card animations for items that moved up.
    if (window.ScrollTrigger) {
      window.ScrollTrigger.refresh();
    }
  };

  groups.forEach(function (group) {
    var groupName = group.getAttribute('data-filter-group');
    var buttons = group.querySelectorAll('[data-filter]');

    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        buttons.forEach(function (other) {
          other.classList.remove('is-active');
        });
        btn.classList.add('is-active');

        state[groupName] = btn.getAttribute('data-filter');
        applyFilters();
      });
    });
  });
};

initAlbumGalleries('.my-gallery');
initPortfolioFilter();
