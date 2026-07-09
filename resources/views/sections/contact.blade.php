<!-- Contact Section Start -->
<section id="contact" class="inner contact">

  <!-- Content Block - H2 Section Title Start -->
  <div class="content__block section-title">
    <p class="h2__subtitle  animate-in-up">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="13px" height="13px" viewBox="0 0 13 13" fill="currentColor">
        <path fill="currentColor" d="M5.6,12.6c-0.5-0.8-0.7-2.4-1.7-3.5c-1-1-2.7-1.2-3.5-1.7C-0.1,7-0.1,6,0.4,5.6c0.8-0.5,2.3-0.6,3.5-1.8
          C5,2.8,5.1,1.2,5.6,0.4C6-0.1,7-0.1,7.4,0.4c0.5,0.8,0.7,2.4,1.8,3.5c1.2,1.2,2.6,1.2,3.5,1.7c0.6,0.4,0.6,1.4,0,1.7
          C11.8,7.9,10.2,8,9.1,9.1c-1,1-1.2,2.7-1.7,3.5C7,13.1,6,13.1,5.6,12.6z"/>
      </svg>
      <span>Contact</span>
    </p>
    <h2 class="h2__title  animate-in-up">Let's make something awesome together!</h2>
  </div>
  <!-- Content Block - H2 Section Title End -->

  <!-- Content Block - Contact Form Start -->
  <div class="content__block grid-block block-grid-large">
    <div class="form-container">

      <!-- Reply Messages Start -->
      <div class="form__reply centered text-center">
        <i class="ph-bold ph-smiley reply__icon"></i>
        <p class="reply__title">Done!</p>
        <span class="reply__text">Thanks for your message. I'll get back as soon as possible.</span>
      </div>
      <!-- Reply Messages End -->

      <!-- Contact Form Start -->
      <form class="form contact-form" id="contact-form" action="{{ route('contact.send') }}" method="POST">
        @csrf
        <div class="container-fluid p-0">
          <div class="row gx-0">
            <div class="col-12 col-md-6 form__item animate-in-up">
              <input type="text" name="name" placeholder="Your Name*" required>
            </div>
            <div class="col-12 col-md-6 form__item animate-in-up">
              <input type="text" name="company" placeholder="Company Name">
            </div>
            <div class="col-12 col-md-6 form__item animate-in-up">
              <input type="email" name="email" placeholder="Email Adress*" required>
            </div>
            <div class="col-12 col-md-6 form__item animate-in-up">
              <input type="tel" name="phone" placeholder="Phone Number*" required>
            </div>
            <div class="col-12 form__item animate-in-up">
              <textarea name="message" placeholder="A Few Words*" required></textarea>
            </div>
            <div class="col-12 form__item animate-in-up">
              <button class="btn btn-default btn-hover btn-hover-accent" type="submit">
                <span class="btn-caption">Send Message</span>
                <i class="ph-bold ph-paper-plane-tilt"></i>
              </button>
            </div>
          </div>
        </div>
      </form>
      <!-- Contact Form End -->

    </div>
  </div>
  <!-- Content Block - Contact Form End -->

  <!-- Content Block - Socials Cards Start -->
  <div class="content__block grid-block">
    <div class="socials-cards d-flex justify-content-start flex-wrap">
      <!-- socials item -->
      <div class="socials-cards__item d-flex grid-item-s animate-card-5">
        <div class="socials-cards__card">
          <i class="ph-bold ph-facebook-logo"></i>
          <a class="socials-cards__link" href="{{ $settings['facebook_url'] ?? '#' }}" target="_blank"></a>
        </div>
      </div>
      <!-- socials item -->
      <div class="socials-cards__item d-flex grid-item-s animate-card-5">
        <div class="socials-cards__card">
          <i class="ph-bold ph-instagram-logo"></i>
          <a class="socials-cards__link" href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank"></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Content Block - Socials Cards End -->

  <!-- Content Block - Teaser Start -->
  <div class="content__block">
    <div class="teaser">
      <p class="teaser__text animate-in-up">Want to know more about me, tell me
        about your project or just to say hello?
        <a class="text-link-bold" href="mailto:{{ $settings['email'] ?? '' }}?subject=Message%20from%20your%20site">Drop me a line</a>
        and I'll get back
        as soon as possible.
      </p>
    </div>
  </div>
  <!-- Content Block - Teaser End -->

  <!-- Content Block - Contact Data Start -->
  <div class="content__block">
    <div class="container-fluid p-0 contact-lines animate-in-up">
      <div class="row g-0 contact-lines__item">
        <!-- data item -->
        <div class="col-12 col-md-4 contact-lines__data">
          <p class="contact-lines__title animate-in-up">Location</p>
          <p class="contact-lines__text animate-in-up">
            <a class="text-link-bold" href="{{ $settings['location_map_url'] ?? '#' }}" target="_blank">{{ $settings['location_text'] ?? '' }}</a>
          </p>
        </div>
        <!-- data item -->
        <div class="col-12 col-md-4 contact-lines__data">
          <p class="contact-lines__title animate-in-up">Phone</p>
          <p class="contact-lines__text animate-in-up">
            <a class="text-link-bold" href="tel:{{ $settings['phone_tel'] ?? '' }}">{{ $settings['phone'] ?? '' }}</a>
          </p>
        </div>
        <!-- data item -->
        <div class="col-12 col-md-4 contact-lines__data">
          <p class="contact-lines__title animate-in-up">Email</p>
          <p class="contact-lines__text animate-in-up">
            <a class="text-link-bold" href="mailto:{{ $settings['email'] ?? '' }}?subject=Message%20from%20your%20site">{{ $settings['email'] ?? '' }}</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- Content Block - Contact Data End -->

</section>
<!-- Contact Section End -->
