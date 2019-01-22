<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Emanuel Evangelical Lutheran Church - Welcome!</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container-fluid homepage-v2">
    <?php require_once('./partials/masthead-top-nav-v2.phtml') ?>

    <div class="main-content">
      <div class="module-container welcome">Welcome</div>
      <div class="module-container service-times">Service Times</div>
      <div class="module-container location">Location</div>
      <div class="module-container map">Map</div>
      <div class="module-container photo-carousel">Photo Carousel</div>
      <div class="module-container worship-audio">NEW Audio Promo</div>
      <div class="module-container upcoming-events">Upcoming Events</div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
  <script src="./js/home.js"></script>
</body>

</html>
