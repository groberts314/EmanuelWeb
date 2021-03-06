<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Emanuel Evangelical Lutheran Church - Welcome!</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container homepage-v2">
    <?php require_once('./partials/masthead-top-nav.phtml') ?>

    <div class="main-content">
      <div class="module-container service-times">
          <?php require_once('./partials/homepage-v2-service-times.phtml') ?>
      </div>
      <div class="module-container photo-carousel" id="photo-carousel-container">
          <?php /* Photo Carousel */ ?>
          <?php /*require_once('./partials/homepage-v2-photo-carousel.phtml')*/ ?>

          <div class="fluid-width-video-wrapper">
            <?php /* Worship Video embedded from YouTube in "fluid width" container */ ?>
            <?php /*<iframe class="video-iframe" src="https://www.youtube-nocookie.com/embed/fpG8BLY_83M" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>*/ ?>

            <?php /* Vimeo Live Stream (Recurring Event) */ ?>
            <iframe class="video-iframe" src="https://vimeo.com/event/812403/embed" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div>

          <?php /*<p style="font-weight: bold; margin-top: 22px; text-align: center">
            Emanuel Online Good Friday April 2, 2021
          </p>*/ ?>
      </div>
      <div class="module-container worship-audio">
          <?php /*require_once('./partials/homepage-v2-audio-promo.phtml')*/ ?>
          <?php require_once('./partials/homepage-v2-sunday-school-online-promo.phtml') ?>
      </div>
      <div class="module-container location">
          <?php require_once('./partials/homepage-v2-location-and-contact.phtml') ?>
      </div>
      <div class="module-container upcoming-events">
          <?php require_once('./partials/homepage-v2-upcoming-events.phtml') ?>
          <?php /*require_once('./partials/homepage-v2-temp-coronavirus-upcoming-events.phtml')*/ ?>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
  <script src="./js/home.js"></script>
</body>

</html>
