<?php
  // Turn on Error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Include helper Functions
  require_once('./app-code/helper-functions.php');

  // Default to Current Year
  $currentYear = date('Y');
  $currentMonth = date('m');
  
  // See if we have a year in the URL (rewrite in `.htaccess` puts it into the query string)
  $queryStringYearAsString = get($_GET['year'], null);
  $hasQueryStringYear = $queryStringYearAsString !== null;
  $queryStringYear = $hasQueryStringYear ? (int)$queryStringYearAsString : NULL;
    
  // If the year is in the future, 404 Not Found
  if ($hasQueryStringYear && $queryStringYear > $currentYear) {
    http_response_code(404);
    require_once('./404.php');
    return;
  }

  // Determine if we're in the current year or a past year
  $isPastYear = $hasQueryStringYear && $queryStringYear < $currentYear;
  $isCurrentYear = !$isPastYear;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Newsletter | Emanuel Evangelical Lutheran Church</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container layout-v2">
    <?php require_once('./partials/masthead-top-nav.phtml') ?>

    <div class="row main-content inner-page-content">
      <div class="col-xs-12">
        <h1 class="page-title">&ldquo;The Good News&rdquo; &ndash; Emanuel&rsquo;s Monthly Newsletter</h1>
        <div class="row">
          <div class="col-xs-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Panel title</h3>
              </div>
              <div class="panel-body">
                Panel content
              </div>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Panel title</h3>
              </div>
              <div class="panel-body">
                Panel content
              </div>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Panel title</h3>
              </div>
              <div class="panel-body">
                Panel content
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>