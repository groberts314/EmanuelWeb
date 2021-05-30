<?php
    http_response_code(410);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Page Removed | Emanuel Evangelical Lutheran Church</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container layout-v2">
    <?php require_once('./partials/masthead-top-nav.phtml') ?>

    <div class="row main-content inner-page-content">
      <div class="col-xs-12 col-sm-6">
        <h1 class="page-title">Page Removed</h1>
        <div class="row">
          <div class="col-xs-12">
            <p>
              The page you were looking for has been removed from our website.<br />
              Please try our navigation menu to see if you can find where you were going.
            </p>
          </div>
          <div class="col-xs-12 col-sm-6 photo-left top-margin">
            <img src="/images/who-we-are/emanuel-sign.jpg" alt="Emanuel: God With Us" />
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 photo-right no-btm-margin">
        <img src="/images/410-gone.jpg" alt="410 Gone (Page Removed)" />
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>
