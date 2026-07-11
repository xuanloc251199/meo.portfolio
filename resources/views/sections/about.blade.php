<!-- About Section Start -->
<section id="about" class="inner about">

  <!-- Content Block - H2 Section Title Start -->
  <div class="content__block section-grid-title">
    <p class="h2__subtitle animate-in-up">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="13px" height="13px" viewBox="0 0 13 13" fill="currentColor">
        <path fill="currentColor" d="M5.6,12.6c-0.5-0.8-0.7-2.4-1.7-3.5c-1-1-2.7-1.2-3.5-1.7C-0.1,7-0.1,6,0.4,5.6c0.8-0.5,2.3-0.6,3.5-1.8
          C5,2.8,5.1,1.2,5.6,0.4C6-0.1,7-0.1,7.4,0.4c0.5,0.8,0.7,2.4,1.8,3.5c1.2,1.2,2.6,1.2,3.5,1.7c0.6,0.4,0.6,1.4,0,1.7
          C11.8,7.9,10.2,8,9.1,9.1c-1,1-1.2,2.7-1.7,3.5C7,13.1,6,13.1,5.6,12.6z"/>
      </svg>
      <span>{{ __('About Me') }}</span>
    </p>
    <h2 class="h2__title animate-in-up">{{ __('Turning complex problems into simple things') }}</h2>
  </div>
  <!-- Content Block - H2 Section Title End -->

  <!-- Content Block - Achievements Start -->
  <div class="content__block grid-block">
    <div class="achievements d-flex flex-column flex-md-row align-items-md-stretch">
      @foreach ($achievements as $achievement)
      <!-- achievements single item -->
      <div class="achievements__item d-flex flex-column grid-item animate-card-3">
        <div class="achievements__card">
          <p class="achievements__number">{{ $achievement->number }}</p>
          <p class="achievements__descr">{{ $achievement->tr('label') }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <!-- Content Block - Achievements End -->

  <!-- Content Block - About Me Data Start -->
  <div class="content__block grid-block block-large">
    <div class="container-fluid p-0">
      <div class="row g-0 justify-content-between">

        <!-- About Me Description Start -->
        <div class="col-12 col-xl-8 grid-item about-descr">
          <p class="about-descr__text animate-in-up">
            {{ $settings['about_text'] ?? '' }}
          </p>
          <div class="btn-group about-descr__btnholder animate-in-up">
            <a target="_blank" class="btn mobile-vertical btn-default btn-hover btn-hover-accent" href="{{ $settings['about_cv_url'] ?? '#' }}">
              <span class="btn-caption">{{ __('Download CV') }}</span>
              <i class="ph-bold ph-download-simple"></i>
            </a>
          </div>
        </div>
        <!-- About Me Description End -->

        <!-- About Me Information Start -->
        <div class="col-12 col-xl-4 grid-item about-info">
          <div class="about-info__item animate-in-up">
            <h6>
              <small class="top">{{ __('Name') }}</small>
              {{ $settings['name'] ?? '' }}
            </h6>
          </div>
          <div class="about-info__item animate-in-up">
            <h6>
              <small class="top">{{ __('Phone') }}</small>
              <a class="text-link-bold" href="tel:{{ $settings['phone_tel'] ?? '' }}">{{ $settings['phone'] ?? '' }}</a>
            </h6>
          </div>
          <div class="about-info__item animate-in-up">
            <h6>
              <small class="top">{{ __('Email') }}</small>
              <a class="text-link-bold" href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a>
            </h6>
          </div>
          <div class="about-info__item animate-in-up">
            <h6>
              <small class="top">{{ __('Location') }}</small>
              <a class="text-link-bold" href="{{ $settings['location_map_url'] ?? '#' }}" target="_blank">{{ $settings['location_text'] ?? '' }}</a>
            </h6>
          </div>
        </div>
        <!-- About Me Information End -->

      </div>
    </div>
  </div>
  <!-- Content Block - About Me Data End -->

  <!-- Content Block - Services Start -->
  <div class="content__block grid-block">
    <div class="container-fluid p-0">
      <div class="row g-0 align-items-stretch cards">
        @foreach ($services as $service)
        <!-- services cards grid single item -->
        <div class="col-12 col-md-6 cards__item grid-item animate-card-2">
          <div class="cards__card d-flex flex-column">
            <div class="cards__descr">
              <h4 class="cards__title animate-in-up">{{ $service->tr('title') }}</h4>
              <div class="cards__tags d-flex flex-wrap animate-in-up">
                @foreach ($service->tags as $tag)
                <span class="rounded-tag tag-outline">{{ $tag->name }}</span>
                @endforeach
              </div>
              <p class="small cards__text animate-in-up">{{ $service->tr('description') }}</p>
            </div>
            <div class="cards__image d-flex animate-in-up">
              <img src="{{ $service->image_url }}" alt="Service/Feature Image">
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
  <!-- Content Block - Services End -->

</section>
<!-- About Section End -->
