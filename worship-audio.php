<?php
  // Turn on Error reporting
  // In case the JSON data gets malformed or some such we'll know about it!
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once('./app-code/helper-functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Worship Audio Recordings | Emanuel Evangelical Lutheran Church</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container layout-v2">
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
        <div class="audio-file-list-v2">
          <?php
            $audioFilesJson = file_get_contents('./app-data/audio-files.json');
            $audioFiles = json_decode($audioFilesJson, TRUE);
            date_sort_descending($audioFiles);

            foreach ($audioFiles as $key => $audioFile) {
              $fileDateTime = strtotime($audioFile['dateTime']);
              $date = date('l, F j, Y', $fileDateTime);
              $time = date('g:i A', $fileDateTime);
              $entry = array_merge($audioFile, array('date' => $date, 'time' => $time));
              display('./partials/worship-audio-entry-v2.phtml', $entry);
            }
          ?>
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
