<?php
  // Turn on Error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once('./app-code/helper-functions.php');
  require_once('./app-code/db-config.php');
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
        <?php
          // Default to Current Month
          $dateRangeStart = date('Y-m-01');
          $dateRangeEnd = date('Y-m-t');
          $isMonthSpecifiedByParameters = false;

          // Check for query parameters
          $year = get($_GET['year'], null);
          $month = get($_GET['month'], null);

          if ($year !== null && $month !== null) {
            // If we have a year and month from query, construct range for that month
            $dateRangeStart = $year . '-' . $month . '-01';
            $dateRangeEnd = date('Y-m-t', strtotime($dateRangeStart));
            $isMonthSpecifiedByParameters = true;
          }

          // Echo <h1> page title tag which includes month and year
          echo '<h1 class="page-title">Sunday School Online &ndash; ' . date_format(date_create($dateRangeStart), 'F Y') . '</h1>';

          // Calculate data range start and end for next month and previous month
          $nextMonthStart = date_format(date_add(date_create($dateRangeStart), date_interval_create_from_date_string('1 month')), 'Y-m-d');
          $nextMonthEnd = date('Y-m-t', strtotime($nextMonthStart));

          $prevMonthStart = date_format(date_sub(date_create($dateRangeStart), date_interval_create_from_date_string('1 month')), 'Y-m-d');
          $prevMonthEnd = date('Y-m-t', strtotime($prevMonthStart));

          try {
            // Setup DB Connection
            $dbConn = new PDO(DB_PDO_CONNECTION_STRING, DB_USER, DB_PASSWORD);
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query for Current Month's Videos
            $dbStmtCurrentMonth = $dbConn->prepare("SELECT * FROM sunday_school_online_videos WHERE `date` BETWEEN :dateRangeStart AND :dateRangeEnd ORDER BY `date` DESC;");
            $dbStmtCurrentMonth->bindParam(':dateRangeStart', $dateRangeStart, PDO::PARAM_STR);
            $dbStmtCurrentMonth->bindParam(':dateRangeEnd', $dateRangeEnd, PDO::PARAM_STR);
            $dbStmtCurrentMonth->execute();
            $dbStmtCurrentMonth->setFetchMode(PDO::FETCH_ASSOC);
            $currentMonthVideos = $dbStmtCurrentMonth->fetchAll();

            // If no videos for current month, and the month was not
            // specified by parameters, we will need to determine latest month
            // that does have videos, and recenter around that month
            if (!$isMonthSpecifiedByParameters && count($currentMonthVideos) === 0) {
              // Query for latest month that does have videos
              $dbStmtMaxVideoDate = $dbConn->prepare("SELECT MAX(`date`) AS latest_video_date FROM sunday_school_online_videos;");
              $dbStmtMaxVideoDate->execute();
              $dbStmtMaxVideoDate->setFetchMode(PDO::FETCH_ASSOC);
              $maxVideoDateResult = $dbStmtMaxVideoDate->fetch();
              $maxVideoDate = strtotime($maxVideoDateResult['latest_video_date']);

              $dateRangeStart = date('Y-m-01', $maxVideoDate);
              $dateRangeEnd = date('Y-m-t', $maxVideoDate);

              $nextMonthStart = date_format(date_add(date_create($dateRangeStart), date_interval_create_from_date_string('1 month')), 'Y-m-d');
              $nextMonthEnd = date('Y-m-t', strtotime($nextMonthStart));

              $prevMonthStart = date_format(date_sub(date_create($dateRangeStart), date_interval_create_from_date_string('1 month')), 'Y-m-d');
              $prevMonthEnd = date('Y-m-t', strtotime($prevMonthStart));

              $dbStmtCurrentMonth = $dbConn->prepare("SELECT * FROM sunday_school_online_videos WHERE `date` BETWEEN :dateRangeStart AND :dateRangeEnd ORDER BY `date` DESC;");
              $dbStmtCurrentMonth->bindParam(':dateRangeStart', $dateRangeStart, PDO::PARAM_STR);
              $dbStmtCurrentMonth->bindParam(':dateRangeEnd', $dateRangeEnd, PDO::PARAM_STR);
              $dbStmtCurrentMonth->execute();
              $dbStmtCurrentMonth->setFetchMode(PDO::FETCH_ASSOC);
              $currentMonthVideos = $dbStmtCurrentMonth->fetchAll();
            }

            // Query to determine whether videos exist for Next Month and Previous Month
            $nextPrevMonthSql = <<<SQL
SELECT EXISTS (
        SELECT 1
          FROM `sunday_school_online_videos`
         WHERE `date` BETWEEN :nextMonthStart AND :nextMonthEnd
         LIMIT 1
      ) AS has_next_month_videos
     ,EXISTS (
        SELECT 1
          FROM `sunday_school_online_videos`
         WHERE `date` BETWEEN :prevMonthStart AND :prevMonthEnd
         LIMIT 1
      ) AS has_prev_month_videos;
SQL;
            $dbStmtNextPrevMonth = $dbConn->prepare($nextPrevMonthSql);
            $dbStmtNextPrevMonth->bindParam(':nextMonthStart', $nextMonthStart, PDO::PARAM_STR);
            $dbStmtNextPrevMonth->bindParam(':nextMonthEnd', $nextMonthEnd, PDO::PARAM_STR);
            $dbStmtNextPrevMonth->bindParam(':prevMonthStart', $prevMonthStart, PDO::PARAM_STR);
            $dbStmtNextPrevMonth->bindParam(':prevMonthEnd', $prevMonthEnd, PDO::PARAM_STR);
            $dbStmtNextPrevMonth->execute();
            $dbResultNextPrevMonth = $dbStmtNextPrevMonth->setFetchMode(PDO::FETCH_ASSOC);
            $nextPrevMonthVideos = $dbStmtNextPrevMonth->fetch();
          } catch (PDOException $e) {
            // echo '<p>An error has occurred.</p>';
            echo '<p>An error has occurred.  ' . $e->getMessage() . '</p>';
          }

          $hasNextMonthVideos = $nextPrevMonthVideos['has_next_month_videos'] === '1';
          $hasPrevMonthVideos = $nextPrevMonthVideos['has_prev_month_videos'] === '1';

          foreach($currentMonthVideos as $key => $video) {
            $videoEntry = array_merge(
              $video,
              array(
                'videoDate' => date('l, F j, Y', strtotime($video['date'])),
                'videoId' => $video['video_id']
              )
            );

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
