<?
  // Turn on Error reporting
  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);

  // Require Helper Functions
  require_once('./app-code/helper-functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <?php
      $pageTitle = 'Emanuel Evangelical Lutheran Church - Welcome!';
      $metadataTitle = 'Emanuel Evangelical Lutheran Church';
      $metadataDescription = 'Emanuel Evangelical Lutheran Church in La Habra, California';
      $metadata = array('title' => $metadataTitle, 'description' => $metadataDescription);
  ?>
  <title><?= $pageTitle ?></title>
  <meta name="description" content="<?= $metadataDescription ?>">
  <?php display('./partials/head-metas-social.phtml', $metadata); ?>
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
            <iframe class="video-iframe" src="https://www.youtube-nocookie.com/embed/8CwEMtqGv1g" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <?php /* Vimeo Live Stream (Recurring Event - Original one) */ ?>
            <?php /* <iframe class="video-iframe" src="https://vimeo.com/event/812403/embed" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe> */ ?>
            <?php /* Vimeo Live Stream (Recurring Event - New One for 9 AM Traditional Worship) */ ?>
            <?php /*<iframe class="video-iframe" src="https://vimeo.com/event/1277638/embed" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>*/ ?>

            <?php /* Vimeo Live Stream (Specific Video) */ ?>
            <?php /*<iframe class="video-iframe" src="https://player.vimeo.com/video/594210586" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>*/ ?>
          </div>

          <?php /*<p style="font-weight: bold; margin-top: 22px; text-align: center">
            We have been having some difficulties with our livestream.<br />
            Sunday, June 1, 2025 Worship video available on <a href="https://www.youtube.com/watch?v=2Oc-VLQSmL8" target="_blank">YouTube</a>.
          </p> */ ?>
      </div>
      <div class="module-container worship-audio"> <?php /* TODO: Replace class `worship-audio` with something more appropriate */ ?>
          <?php require_once('./partials/homepage-v2-bible-readings.phtml') ?>
          <?php /* require_once('./partials/homepage-v2-audio-promo.phtml') */ ?>
          <?php /* require_once('./partials/homepage-v2-sunday-school-online-promo.phtml') */ ?>
          <?php /* require_once('./partials/homepage-v2-praise-worship.phtml')  */ ?>
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
