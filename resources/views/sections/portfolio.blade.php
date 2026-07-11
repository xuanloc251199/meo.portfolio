<!-- Portfolio Section Start -->
<section id="portfolio" class="inner inner-first portfolio">

  <!-- Content Block - H2 Section Title Start -->
  <div class="content__block section-grid-title">
    <p class="h2__subtitle animate-in-up">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="13px" height="13px" viewBox="0 0 13 13" fill="currentColor">
        <path fill="currentColor" d="M5.6,12.6c-0.5-0.8-0.7-2.4-1.7-3.5c-1-1-2.7-1.2-3.5-1.7C-0.1,7-0.1,6,0.4,5.6c0.8-0.5,2.3-0.6,3.5-1.8
          C5,2.8,5.1,1.2,5.6,0.4C6-0.1,7-0.1,7.4,0.4c0.5,0.8,0.7,2.4,1.8,3.5c1.2,1.2,2.6,1.2,3.5,1.7c0.6,0.4,0.6,1.4,0,1.7
          C11.8,7.9,10.2,8,9.1,9.1c-1,1-1.2,2.7-1.7,3.5C7,13.1,6,13.1,5.6,12.6z"/>
      </svg>
      <span>{{ __('Portfolio') }}</span>
    </p>
    <h2 class="h2__title animate-in-up">{{ __('Check out my featured projects') }}</h2>
  </div>
  <!-- Content Block - H2 Section Title End -->

  <!-- Content Block - Type Filter Start -->
  <style>
    .portfolio-filter .filter-btn {
      cursor: pointer;
      transition: all .25s ease;
      height: 3.4rem;
      padding: 0 1.4rem;
      background-color: transparent;
    }
    .portfolio-filter .filter-btn.is-active {
      background-color: var(--accent);
      border-color: var(--accent);
      color: var(--t-opp-bright);
    }
    .portfolio-filter .filter-label {
      align-self: center;
      margin: 0.5rem 1.4rem 0.5rem 0;
      color: var(--t-medium);
      min-width: 8rem;
    }
  </style>
  @php
    $presentTypes = $projects->pluck('type')->unique();
    $presentCategories = $projects->flatMap(fn ($p) => $p->tags)
        ->filter(fn ($t) => $t->type === \App\Models\Tag::TYPE_CATEGORY)
        ->unique('id')
        ->sortBy('name');
  @endphp
  <div class="content__block portfolio-filter animate-in-up">
    <div class="card__tags d-flex flex-wrap" data-filter-group="type">
      <span class="small filter-label">{{ __('Project type') }}</span>
      <button type="button" class="rounded-tag tag-outline filter-btn is-active" data-filter="all">{{ __('All') }}</button>
      @foreach (\App\Models\Project::TYPE_LABELS as $typeKey => $typeLabel)
        @continue(! $presentTypes->contains($typeKey))
        <button type="button" class="rounded-tag tag-outline filter-btn" data-filter="{{ $typeKey }}">{{ __($typeLabel) }}</button>
      @endforeach
    </div>
    <div class="card__tags d-flex flex-wrap" data-filter-group="tag">
      <span class="small filter-label">{{ __('Category') }}</span>
      <button type="button" class="rounded-tag tag-outline filter-btn is-active" data-filter="all">{{ __('All') }}</button>
      @foreach ($presentCategories as $categoryTag)
        <button type="button" class="rounded-tag tag-outline filter-btn" data-filter="{{ $categoryTag->name }}">{{ $categoryTag->name }}</button>
      @endforeach
    </div>
  </div>
  <!-- Content Block - Type Filter End -->

  <!-- Content Block - Works Gallery Start -->
  <div class="content__block grid-block">
    <div class="container-fluid px-0 inner__gallery">
      <div class="row gx-0 my-gallery" itemscope itemtype="http://schema.org/ImageGallery">

        @foreach ($projects as $project)
        <!-- Works Gallery Single Item Start -->
        <figure class="col-12 col-md-6 gallery__item grid-item animate-card-2" data-type="{{ $project->type }}" data-tags="{{ json_encode($project->tags->pluck('name')) }}" data-album="{{ json_encode($project->album_items) }}" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
          <a href="{{ $project->image_url }}" data-image="{{ $project->image_url }}" class="gallery__link" itemprop="contentUrl" data-size="{{ $project->size }}">
            <img src="{{ $project->image_url }}" class="gallery__image" itemprop="thumbnail" alt="{{ $project->tr('title') }}" loading="lazy">
          </a>
          <figcaption class="gallery__descr{{ $project->opposite ? ' opposite' : '' }}" itemprop="caption description">
            <h5 @if ($project->opposite) class="opposite" @endif>{{ $project->tr('title') }}</h5>
            <div class="card__tags d-flex flex-wrap">
              @foreach ($project->tags as $tag)
              <span class="rounded-tag{{ $project->opposite ? '' : ' opposite' }}">{{ $tag->name }}</span>
              @endforeach
            </div>
            <p class="small">{{ $project->tr('description') }}<br><br>
              @if ($project->link)
              <a class="btn btn-default btn-fullwidth btn-hover btn-hover-accent" href="{{ $project->link }}" target="_blank"><span class="btn-caption">{{ __('Detail') }}</span>
              </a>
              @endif
            </p>
          </figcaption>
        </figure>
        <!-- Works Gallery Single Item End -->
        @endforeach

      </div>
    </div>
  </div>
  <!-- Content Block - Works Gallery End -->

</section>
<!-- Portfolio Section End -->
