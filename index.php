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

            <?php /* Vimeo Live Stream (Recurring Event - Original one) */ ?>
            <?php /* <iframe class="video-iframe" src="https://vimeo.com/event/812403/embed" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe> */ ?>
            <?php /* Vimeo Live Stream (Recurring Event - New One for 9 AM Traditional Worship) */ ?>
            <iframe class="video-iframe" src="https://vimeo.com/event/1277638/embed" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

            <?php /* Vimeo Live Stream (Specific Video) */ ?>
            <?php /*<iframe class="video-iframe" src="https://player.vimeo.com/video/594210586" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>*/ ?>
          </div>

          <?php /*<p style="font-weight: bold; margin-top: 22px; text-align: center">
            Emanuel Online Good Friday April 2, 2021
          </p>*/ ?>
          <h2 style="margin-top: 22px">Feedback Needed</h2>
          <p>
            Please take this survey to help out our Transition Team.
          </p>
          <div style="margin: 22px auto 0; text-align: center;">
            <a
              class="btn"
              href="https://easy-feedback.com/EmanuelHeritageSurvey/1421256/RbA4BK-94bd0d00e32ab21df4c5cdfdb2125cb4"
              style="background-color: #800000; border-color: #80715e; color: #fff; font-size: 18px;"
              target="_blank">
              Take the Survey
              <span class="glyphicon glyphicon-new-window" aria-hidden="true" style="top: 3px;"></span>
            </a>
          </div>
      </div>
      <div class="module-container worship-audio"> <?php /* TODO: Replace class `worship-audio` with something more appropriate */ ?>
          <?php /*require_once('./partials/homepage-v2-audio-promo.phtml')*/ ?>
          <?php /* require_once('./partials/homepage-v2-sunday-school-online-promo.phtml') */ ?>
          <?php require_once('./partials/homepage-v2-praise-worship.phtml') ?>
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
