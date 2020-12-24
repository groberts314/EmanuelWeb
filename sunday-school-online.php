<?php
  // Turn on Error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once('./app-code/helper-functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Sunday School Online | Emanuel Evangelical Lutheran Church</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container layout-v2">
    <?php require_once('./partials/masthead-top-nav.phtml') ?>

    <div class="row main-content inner-page-content">
      <div class="col-xs-12 col-sm-8">
        <h1 class="page-title">Sunday School Online</h1>

        <?php
          // Default to Current Month
          $dateRangeStart = date('Y-m-01');
          $dateRangeEnd = date('Y-m-t');

          // Check for query parameters
          $year = get($_GET['year'], null);
          $month = get($_GET['month'], null);

          if ($year !== null && $month !== null) {
            // If we have a year and month from query, construct range for that month
            $dateRangeStart = $year . '-' . $month . '-01';
            $dateRangeEnd = date('Y-m-t', strtotime($dateRangeStart));
          }

          $nextMonthStart = date_format(date_add(date_create($dateRangeStart), date_interval_create_from_date_string('1 month')), 'Y-m-d');
          $nextMonthEnd = date('Y-m-t', strtotime($nextMonthStart));

          $prevMonthStart = date_format(date_sub(date_create($dateRangeStart), date_interval_create_from_date_string('1 month')), 'Y-m-d');
          $prevMonthEnd = date('Y-m-t', strtotime($prevMonthStart));

          $sundaySchoolVideos = require_once('./app-data/sunday-school-online-videos.php');

          $currentMonthVideos = array_filter(
            $sundaySchoolVideos,
            function($video) use ($dateRangeStart, $dateRangeEnd) {
              return is_date_in_range($dateRangeStart, $dateRangeEnd, $video['date']);
            }
          );

          $nextMonthVideos = array_filter(
            $sundaySchoolVideos,
            function($video) use ($nextMonthStart, $nextMonthEnd) {
              return is_date_in_range($nextMonthStart, $nextMonthEnd, $video['date']);
            }
          );

          $hasNextMonthVideos = count($nextMonthVideos) !== 0;

          $prevMonthVideos = array_filter(
            $sundaySchoolVideos,
            function($video) use ($prevMonthStart, $prevMonthEnd) {
              return is_date_in_range($prevMonthStart, $prevMonthEnd, $video['date']);
            }
          );

          $hasPrevMonthVideos = count($prevMonthVideos) !== 0;

          foreach($currentMonthVideos as $key => $video) {
            $videoDate = date('l, F j, Y', strtotime($video['date']));
            $videoEntry = array_merge($video, array('videoDate' => $videoDate));
            display('./partials/sunday-school-video.phtml', $videoEntry);
          }
        ?>
        <div class="row" style="margin: 22px auto">
          <div class="col-xs-6">
            <?php
              if ($hasPrevMonthVideos) {
                echo '<a href="/sunday-school-online/' . date('Y', strtotime($prevMonthStart)) . '/' . date('m', strtotime($prevMonthStart)) . '"> &lt; Previous Month</a>';
              } else {
                echo '&nbsp;';
              }
            ?>
          </div>
          <div class="col-xs-6" style="text-align: right">
            <?php
              if ($hasNextMonthVideos) {
                echo '<a href="/sunday-school-online/' . date('Y', strtotime($nextMonthStart)) . '/' . date('m', strtotime($nextMonthStart)) . '">Next Month &gt;</a>';
              } else {
                echo '&nbsp;';
              }
            ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 photo-right no-btm-margin">
        <img src="/images/who-we-are/emanuel-sign.jpg" alt="Emanuel: God With Us" />
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>
