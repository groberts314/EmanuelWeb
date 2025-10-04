<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Event Calendar | Emanuel Evangelical Lutheran Church</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container layout-v2">
    <?php require_once('./partials/masthead-top-nav.phtml') ?>

    <div class="row main-content">
      <div class="col-xs-12">
        <h1 class="page-title">Event Calendar</h1>
        <p>
          <?php
            $transitionDate = '2025-10-01'; // When adding next month's calendar, just update this
            $pacificTimeZone = new DateTimeZone('America/Los_Angeles');
            $now = new DateTime("now", $pacificTimeZone);
            $beginningOfNextMonth = new DateTime($transitionDate, $pacificTimeZone);
            $lastMonth = clone $beginningOfNextMonth;
            $lastMonth->sub(new DateInterval('P1D'));
            $monthNum = $lastMonth->format('m');
            $monthName = $lastMonth->format('F');
            $year = $lastMonth->format('Y');

            if ($now > $beginningOfNextMonth) {
              $monthNum = $beginningOfNextMonth->format('m');
              $monthName = $beginningOfNextMonth->format('F');
              $year = $beginningOfNextMonth->format('Y');
            }

            echo <<<HTML
              <a href="./calendars/calendar-$year-$monthNum.pdf" target="_blank">$monthName $year printer-friendly calendar</a>
HTML;
          ?>
        </p>
        <? /* BEGIN: Embedded Google Calendar */?>
        <? /* Mobile Version*/ ?>
        <div class="google-container-container visible-xs-block">
          <iframe
            src="https://calendar.google.com/calendar/embed?src=churchinfo150%40gmail.com&ctz=America%2FLos_Angeles&mode=AGENDA"
            style="border: 0"
            width="100%"
            height="1000"
            frameborder="0"
            scrolling="no">
          </iframe>
        </div>
        <? /* Wider (Regular) Version*/ ?>
        <div class="google-container-container hidden-xs">
          <iframe
            src="https://calendar.google.com/calendar/embed?src=churchinfo150%40gmail.com&ctz=America%2FLos_Angeles"
            style="border: 0"
            width="100%"
            height="600"
            frameborder="0"
            scrolling="no">
          </iframe>
        </div>
        <? /* END: Embedded Google Calendar */?>
        <? /* Embedded calendar from Breeze ChMS seems to be blank; it has no events on it */?>
        <?/* <iframe src="https://emanuellutheran.breezechms.com/embed/calendar/grid?size=medium&color=gray&calendars=srg9ErllnQBH%2BDD4NjLNQb4cUJHWej5sy5FLrtsbUc4x%2FLSC%2Fo4x2MFxxOZAJ4jli3mdvTLaVJQ5UvZ8ZI%2B31Q%3D%3D"
                seamless="seamless"
                width="100%"
                height="910"
                scrolling="auto"
                frameborder="0"
                style="border-width: 0px;">
        </iframe> */?>
        <? /* For now, just show an image of the PDF calendar */?>
        <?php /*
        <?php
            echo <<<HTML
            <div class="calendar-image-container">
              <img src="images/calendars/calendar-$year-$monthNum.jpg" alt="$monthName $year Event Calendar" />
            </div>
HTML;
        ?>
        */ ?>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
  <script type="text/javascript" src="./js/calendar.js"></script>
</body>

</html>
