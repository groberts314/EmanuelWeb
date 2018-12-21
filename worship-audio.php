<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Worship Audio Recordings | Emanuel Evangelical Lutheran Church</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container">
    <?php require_once('./partials/masthead-top-nav.phtml') ?>

    <div class="row main-content inner-page-content short-content-min-height">
      <div class="col-xs-12 col-sm-8">
        <h1 class="page-title">Worship Audio Recordings</h1>
        <div class="row">
          <div class="col-xs-12">
            <p>
              Emanuel Lutheran Church has started recording its worship services
              and providing the audio recordings online!
            </p>
          </div>
        </div>
        <div class="audio-file-list">
          <div class="row audio-file-entry">
            <div class="col-xs-2 col-lg-1">
              <img src="images/audio.png" alt="Audio" />
            </div>
            <div class="col-xs-10 col-lg-3">
              <strong>
                Sunday,&nbsp;December&nbsp;9,&nbsp;2018 9:00 AM
              </strong>
            </div>
            <div class="col-xs-12 col-lg-5 audio-player">
              <audio controls preload="none">
                <source src="audio/emanuel-9am-worship-2018-12-09.m4a" type="audio/mp4" />
                <p>Your browser does not support HTML5 audio.</p>
              </audio>
            </div>
            <div class="col-xs-12 col-lg-3 audio-download">
              <a href="audio/emanuel-9am-worship-2018-12-09.m4a">
                <strong>Download (M4A)</strong>
              </a>
            </div>
          </div>
          <div class="row audio-file-entry">
            <div class="col-xs-2 col-lg-1">
              <img src="images/audio.png" alt="Audio" />
            </div>
            <div class="col-xs-10 col-lg-3">
              <strong>
                Sunday,&nbsp;December&nbsp;16,&nbsp;2018 9:00 AM
              </strong>
            </div>
            <div class="col-xs-12 col-lg-5 audio-player">
              <audio controls preload="none">
                <source src="audio/emanuel-9am-worship-2018-12-16.m4a" type="audio/mp4" />
                <p>Your browser does not support HTML5 audio.</p>
              </audio>
            </div>
            <div class="col-xs-12 col-lg-3 audio-download">
              <a href="audio/emanuel-9am-worship-2018-12-16.m4a">
                <strong>Download (M4A)</strong>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 photo-right no-btm-margin">
        <img src="images/who-we-are/emanuel-sign.jpg" alt="Emanuel: God With Us" />
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>
