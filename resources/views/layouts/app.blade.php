<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

  <head>
    <meta charset="UTF-8">

    <!-- Page Title -->
    <title>@yield('title', "Xuan Loc's Portfolio")</title>

    <!-- Meta Tags -->
    <meta name="description" content="Show yourself brightly with Braxton - unique and creative portfolio and resume template!">
    <meta name="keywords" content="mix_design, resume, portfolio, personal page, cv, template, one page, responsive, html5, css3, creative, clean">
    <meta name="author" content="mix_design">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Viewport Meta-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Template Favicon & Icons Start -->
    <link rel="icon" href="{{ asset('img/favicon/favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('img/favicon/icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/manifest.webmanifest') }}">
    <!-- Template Favicon & Icons End -->

    <!-- Facebook Metadata Start -->
    <meta property="og:image:height" content="1200">
    <meta property="og:image:width" content="1200">
    <meta property="og:title" content="Xuan Loc's Portfolio">
    <meta property="og:description" content="Show the projects that I have done. My experiences in the fields of Media, Event, and Development.">
    <meta property="og:image" content="{{ asset('img/og-image.jpg') }}">
    <!-- Facebook Metadata End -->

    <!-- Template Styles Start -->
    <link rel="stylesheet" href="{{ asset('css/loaders/loader.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Template Styles End -->

    <!-- Custom Browser Color Start -->
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#dcdce7">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#111111">
    <meta name="msapplication-navbutton-color" content="#111111">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <!-- Custom Browser Color End -->
  </head>

  <body>

    <!-- Loader Start -->
    <!-- <div id="loader" class="loader">
      <div id="loaderContent" class="loader__content">
        <div class="loader__shadow"></div>
        <div class="loader__box"></div>
      </div>
    </div> -->
    <!-- Loader End -->

    @include('partials.header')

    <!-- Image Background Layer Start -->
    <div id="imageBackground" class="image-background" data-speed="0.4"></div>
    <!-- Image Background Layer End -->

    @include('partials.avatar')

    <!-- Page Content Start -->
    <div id="content" class="content">
      <div class="content__wrapper">
        @yield('content')
      </div>
    </div>
    <!-- Page Content End -->

    @include('partials.photoswipe')

    <!-- Load Scripts Start -->
    <script src="{{ asset('js/libs.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/gallery-init.js') }}"></script>
    <!-- Load Scripts End -->

  </body>

</html>
