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
            $pacificTimeZone = new DateTimeZone('America/Los_Angeles');
            $now = new DateTime("now", $pacificTimeZone);
            $beginningOfNextMonth = new DateTime('2024-12-01', $pacificTimeZone);

            if ($now > $beginningOfNextMonth) {
              echo <<<HTML
              <a href="./calendars/calendar-2024-12.pdf" target="_blank">December 2024 printer-friendly calendar</a>
HTML;
            } else {
              echo <<<HTML
              <a href="./calendars/calendar-2024-11.pdf" target="_blank">November 2024 printer-friendly calendar</a>
HTML;
            }
          ?>
        </p>
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
        <?php
          if ($now > $beginningOfNextMonth) {
            echo <<<HTML
            <img src="images/calendars/calendar-2024-12.jpg" alt="December 2024 Event Calendar" />
HTML;
          } else {
            echo <<<HTML
            <img src="images/calendars/calendar-2024-11.jpg" alt="November 2024 Event Calendar" />
HTML;
          }
        ?>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>
