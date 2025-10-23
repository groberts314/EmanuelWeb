<?php
  // Turn on Error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Include helper Functions
  require_once('./app-code/helper-functions.php');

  // Default to Current Month
  $newsletterYear = date('Y');
  $newsletterMonth = date('m');
  $newsletterDateString = $newsletterYear . '-' . $newsletterMonth . '-01';
  $newsletterDate = date_create($newsletterDateString);
  $isLatestIssue = true;
  
  // See if we have a year and month in the URL (rewrite in `.htaccess` puts it into the query string)
  $queryStringYearAsString = get($_GET['year'], null);
  $queryStringMonthAsString = get($_GET['month'], null);
  $hasQueryStringDate = $queryStringYearAsString !== NULL && $queryStringMonthAsString !== NULL;
  $queryStringDateString = NULL;
  $queryStringDate = NULL;

  if ($hasQueryStringDate) {
    $queryStringDateString = $queryStringYearAsString . '-' . $queryStringMonthAsString . '-01';
    $queryStringDate = date_create($queryStringDateString);

    // If the date is in the future, 404 Not Found
    if ($queryStringDate > new DateTime()) {
      http_response_code(404);
      require_once('./404.php');
      return;
    }

    $newsletterDate = $queryStringDate;
    $newsletterYear = $queryStringYearAsString;
    $newsletterMonth = $queryStringMonthAsString;
    $isLatestIssue = false; // TODO: We don't know this for sure
  } else { // Current Issue
    // TODO: Make sure file for current issue exists
  }
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
        <h1 class="page-title">&ldquo;The Good News&rdquo; &ndash; Emanuel&rsquo;s Monthly Newsletter &ndash; <?= date_format($newsletterDate, 'F Y') ?></h1>
      </div>      
    </div>
    <div class="row main-content inner-page-content">
      <div class="col-xs-12">
        <?php
          //var_dump($queryStringDate);
          /* TODO: Previous and Next Navgation Arrows */
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <iframe src='<?="/newsletters/newsletter-$newsletterYear-$newsletterMonth.pdf"?>' width="100%" height="600px"></iframe>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
</body>

</html>