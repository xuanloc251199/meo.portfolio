<!-- Header Start -->
<header id="header" class="header d-flex justify-content-between">

  <!-- Navigation Menu Start -->
  <div class="header__navigation">
    <nav id="menu" class="menu">
      <ul class="menu__list d-flex justify-content-start">
        <li class="menu__item">
          <a class="menu__link btn" href="#home">
            <span class="menu__caption">Home</span>
            <i class="ph-bold ph-house-simple"></i>
          </a>
        </li>
        <li class="menu__item">
          <a class="menu__link btn" href="#portfolio">
            <span class="menu__caption">Portfolio</span>
            <i class="ph-bold ph-squares-four"></i>
          </a>
        </li>
        <li class="menu__item">
          <a class="menu__link btn" href="#about">
            <span class="menu__caption">About Me</span>
            <i class="ph-bold ph-user"></i>
          </a>
        </li>
        <li class="menu__item">
          <a class="menu__link btn" href="#resume">
            <span class="menu__caption">Resume</span>
            <i class="ph-bold ph-article"></i>
          </a>
        </li>
        <li class="menu__item">
          <a class="menu__link btn" href="#contact">
            <span class="menu__caption">Contact</span>
            <i class="ph-bold ph-envelope"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>
  <!-- Navigation Menu End -->

  <!-- Header Controls Start -->
  <div class="header__controls d-flex justify-content-end">
    <button id="color-switcher" class="color-switcher header__switcher btn" type="button" role="switch" aria-label="light/dark mode" aria-checked="true"></button>
    <a id="notify-trigger" class="header__trigger btn" href="mailto:{{ $settings['email'] ?? '' }}?subject=Message%20from%20your%20site">
      <span class="trigger__caption">Let's Talk</span>
      <i class="ph-bold ph-chat-dots"></i>
    </a>
  </div>
  <!-- Header Controls End -->

</header>
<!-- Header End -->
