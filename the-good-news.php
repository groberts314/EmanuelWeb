<?php
  // Turn on Error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Include helper Functions
  require_once('./app-code/helper-functions.php');

  // Latest Issue Date
  // TODO: Change these values when uploading new PDF file and thumbnail each month -- should be only change required!
  $latestIssueYear = '2025'; 
  $latestIssueMonth = '10';
  // END: Only Values that need to be changed when uploading new newsletter for the monthly update

  $latestIssueDateString = $latestIssueYear . '-' . $latestIssueMonth . '-01';
  $latestIssueDate = DateTimeImmutable::createfromMutable(date_create($latestIssueDateString));

  // Default to Latest Issue
  $newsletterYear = $latestIssueYear;
  $newsletterMonth = $latestIssueMonth;
  $newsletterDate = clone $latestIssueDate;
  $isLatestIssue = true;
  
  // See if we have a year and month in the URL (rewrite in `.htaccess` puts it into the query string)
  $queryStringYearAsString = get($_GET['year'], null);
  $queryStringMonthAsString = get($_GET['month'], null);
  $hasQueryStringDate = $queryStringYearAsString !== NULL && $queryStringMonthAsString !== NULL;
  $queryStringDateString = NULL;
  $queryStringDate = NULL;

  if ($hasQueryStringDate) {
    $queryStringDateString = $queryStringYearAsString . '-' . $queryStringMonthAsString . '-01';
    $queryStringDate = DateTimeImmutable::createfromMutable(date_create($queryStringDateString));

    // If the date is in the future, 404 Not Found
    if ($queryStringDate > $newsletterDate) {
      http_response_code(404);
      require_once('./404.php');
      return;
    }

    $newsletterDate = clone $queryStringDate;
    $newsletterYear = $queryStringYearAsString;
    $newsletterMonth = $queryStringMonthAsString;
    $isLatestIssue = $newsletterDate == $latestIssueDate;
  }

  $newsletterMonthYearFormatted = date_format($newsletterDate, 'F Y');
  $oneMonth = date_interval_create_from_date_string('1 month');
  $nextIssue = $newsletterDate->add($oneMonth);
  $nextIssueYear = $nextIssue->format('Y');
  $nextIssueMonth = $nextIssue->format('m');
  $prevIssue = $newsletterDate->sub($oneMonth);
  $prevIssueYear = $prevIssue->format('Y');
  $prevIssueMonth = $prevIssue->format('m');
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
        <h1 class="page-title" style="margin-bottom: 0">&ldquo;The Good News&rdquo; &ndash; <span class="hidden-xs hidden-sm">Emanuel&rsquo;s Monthly Newsletter &ndash;</span> <?= $newsletterMonthYearFormatted ?></h1>
      </div>      
    </div>
    <div class="row" style="margin-bottom: 11px">
      <div class="col-xs-6 col-sm-4">
        <a href='<?="/the-good-news/$prevIssueYear/$prevIssueMonth" ?>'>&lt; Previous Month</a>
      </div>
      <div class="col-sm-4 hidden-xs">&nbsp;</div>
      <div class="col-xs-6 col-sm-4 text-right">
        <?php
          if ($isLatestIssue) {
            echo <<<HTML
            <a href="javascript:;" disabled="disabled" class="text-muted" style="pointer-events: none;" aria-disabled="true">Next Month &gt;<a>
HTML;
          } else if ($nextIssue == $latestIssueDate) {
            echo <<<HTML
            <a href="/the-good-news">Next Month &gt;<a>
HTML;
          } else {
            echo <<<HTML
            <a href="/the-good-news/$nextIssueYear/$nextIssueMonth">Next Month &gt;<a>
HTML;
          }
        ?>
      </div>
    </div>
    <div class="row hidden-md hidden-lg">
      <div class="col-xs-12">
        <img
          src='<?="/images/newsletter/newsletter-$newsletterYear-$newsletterMonth.jpg" ?>'
          alt='<?="The Good News: $newsletterMonthYearFormatted"?>'
          style="margin-bottom: 22px; width: 100%"
        />
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
