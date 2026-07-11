<!-- Resume Section Start -->
<section id="resume" class="inner resume">

  <!-- Content Block - H2 Section Title Start -->
  <div class="content__block block-large">
    <p class="h2__subtitle animate-in-up">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="13px" height="13px" viewBox="0 0 13 13" fill="currentColor">
        <path fill="currentColor" d="M5.6,12.6c-0.5-0.8-0.7-2.4-1.7-3.5c-1-1-2.7-1.2-3.5-1.7C-0.1,7-0.1,6,0.4,5.6c0.8-0.5,2.3-0.6,3.5-1.8
          C5,2.8,5.1,1.2,5.6,0.4C6-0.1,7-0.1,7.4,0.4c0.5,0.8,0.7,2.4,1.8,3.5c1.2,1.2,2.6,1.2,3.5,1.7c0.6,0.4,0.6,1.4,0,1.7
          C11.8,7.9,10.2,8,9.1,9.1c-1,1-1.2,2.7-1.7,3.5C7,13.1,6,13.1,5.6,12.6z"/>
      </svg>
      <span>{{ __('Resume') }}</span>
    </p>
    <h2 class="h2__title animate-in-up">{{ __('Education and practical experience') }}</h2>
  </div>
  <!-- Content Block - H2 Section Title End -->

  <!-- Content Block - Education Start -->
  <div class="content__block block-large">

    <!-- H3 Block Start -->
    <div class="section-h3">
      <h3 class="h3__title animate-in-up">{{ __('My education') }}</h3>
    </div>
    <!-- H3 Block End -->

    <!-- Education Lines Start -->
    <div class="container-fluid p-0 resume-lines">
      @foreach ($education as $entry)
      <!-- education single item -->
      <div class="row g-0 resume-lines__item animate-in-up">
        <div class="col-12 col-md-2">
          <span class="resume-lines__date animate-in-up">{{ $entry->tr('period') }}</span>
        </div>
        <div class="col-12 col-md-5">
          <h5 class="resume-lines__title animate-in-up">{{ $entry->tr('title') }}</h5>
          @if ($entry->source_name)
          <p class="resume-lines__source animate-in-up">{{ __('Course by') }}
            <a href="{{ $entry->source_url ?? '#0' }}" class="text-link-bold" target="_blank">{{ $entry->source_name }}</a>
          </p>
          @endif
        </div>
        <div class="col-12 col-md-5">
          <p class="small resume-lines__descr animate-in-up">{{ $entry->tr('description') }}</p>
        </div>
      </div>
      @endforeach
    </div>
    <!-- Education Lines End -->

  </div>
  <!-- Content Block - Education End -->

  <!-- Content Block - Experience Start -->
  <div class="content__block block-large">

    <!-- H3 Block Start -->
    <div class="section-h3">
      <h3 class="h3__title animate-in-up">{{ __('Work experience') }}</h3>
    </div>
    <!-- H3 Block End -->

    <!-- Experience Lines Start -->
    <div class="container-fluid p-0 resume-lines">
      @foreach ($experience as $entry)
      <!-- experience single item -->
      <div class="row g-0 resume-lines__item animate-in-up">
        <div class="col-12 col-md-2">
          <span class="resume-lines__date animate-in-up">{{ $entry->tr('period') }}</span>
        </div>
        <div class="col-12 col-md-5">
          <h5 class="resume-lines__title animate-in-up">{{ $entry->tr('title') }}</h5>
          @if ($entry->source_name)
          <p class="resume-lines__source animate-in-up">{{ __('in the') }}
            <a href="{{ $entry->source_url ?? '#0' }}" class="text-link-bold" target="_blank">{{ $entry->source_name }}</a>
          </p>
          @endif
        </div>
        <div class="col-12 col-md-5">
          <p class="small resume-lines__descr animate-in-up">{{ $entry->tr('description') }}</p>
        </div>
      </div>
      @endforeach
    </div>
    <!-- Experience Lines End -->

  </div>
  <!-- Content Block - Experience End -->

  <!-- Content Block - H3 Block Start -->
  <div class="content__block">
    <div class="section-h3 section-h3-grid">
      <h3 class="h3__title animate-in-up">{{ __('My favourite tools') }}</h3>
    </div>
  </div>
  <!-- Content Block - H3 Block End -->

  <!-- Content Block - Tools List Start -->
  <div class="content__block grid-block block-large">
    <!-- Tools List Start -->
    <div class="tools-cards d-flex justify-content-start flex-wrap">
      @foreach ($tools as $tool)
      <!-- tools simgle item -->
      <div class="tools-cards__item d-flex grid-item-s animate-card-5">
        <div class="tools-cards__card">
          <img class="tools-cards__icon animate-in-up" src="{{ $tool->icon_url }}" alt="Tools Icon">
          <h6 class="tools-cards__caption animate-in-up">{{ $tool->name }}</h6>
        </div>
      </div>
      @endforeach
    <!-- Tools List End -->
  </div>
  <!-- Content Block - Tools List End -->

</section>
<!-- Resume Section End -->
