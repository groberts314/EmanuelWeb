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
          <a href="./calendars/calendar-2021-07.pdf" target="_blank">July 2021 printer-friendly calendar</a><br />
          <a href="./calendars/calendar-2021-06.pdf" target="_blank">June 2021 printer-friendly calendar</a>
        </p>
        <iframe src="https://emanuellutheran.breezechms.com/embed/calendar/grid?size=medium&color=gray&calendars=srg9ErllnQBH%2BDD4NjLNQb4cUJHWej5sy5FLrtsbUc4x%2FLSC%2Fo4x2MFxxOZAJ4jli3mdvTLaVJQ5UvZ8ZI%2B31Q%3D%3D"
                seamless="seamless"
                width="100%"
                height="910"
                scrolling="auto"
                frameborder="0"
                style="border-width: 0px;">
        </iframe>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>
