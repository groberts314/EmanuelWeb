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
      <div class="module-container worship-audio">
          <?php require_once('./partials/homepage-v2-audio-promo.phtml') ?>
      </div>
      <div class="module-container location">
          <?php require_once('./partials/homepage-v2-location-and-contact.phtml') ?>
      </div>
      <div class="module-container photo-carousel" id="photo-carousel-container">
          <?php /*require_once('./partials/homepage-v2-photo-carousel.phtml')*/ ?>
          <?php /*<video controls>
            <source src="./video/EmanuelWorship_2020-04-05.mp4" type="video/mp4">
              Your browser does not support the video tag.
          </video>
          */?>
          <?php /* Worship Video embedded from YouTube in "fluid width" container */ ?>
          <div class="fluid-width-video-wrapper">
            <iframe class="video-iframe" src="https://www.youtube-nocookie.com/embed/TixLc1dg2ew" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <p style="margin-top: 22px; text-align: center">
            <strong>Emanuel Online Sunday June 21, 2020</strong><br />
          </p>
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
