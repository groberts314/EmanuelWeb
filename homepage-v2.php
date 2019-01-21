<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('./partials/head-metas.phtml') ?>
  <title>Emanuel Evangelical Lutheran Church - Welcome!</title>
  <?php require_once('./partials/head-includes.phtml') ?>
</head>

<body>
  <div class="container-fluid homepage-v2">
    <?php require_once('./partials/masthead-top-nav-v2.phtml') ?>

    <div class="row main-content">
      <div class="col-md-3">
        <div class="row">
          <div class="col-sm-6 col-md-12">
            <div class="module-container service-times-container">
              <h2 class="left-top">Welcome to Emanuel!</h2>
              <p>We invite you to join us on Sundays for traditional or contemporary worship.</p>
              <p>For first-time visitors make sure to check out the <a href="./who-we-are">Who We Are</a> and <a href="./worship">Worship</a> sections of our website.</p>
              <h2 class="worship-schedule-title left-top">Worship Schedule</h2>
              <p class="notice">All Sunday worship services offer communion</p>
              <ul class="service-time-list">
                <li class="service-time-entry clearfix">
                  <div class="service-time">9:00 am</div>
                  <div class="service-desc">Traditional Worship Service</div>
                </li>
                <li class="service-time-entry clearfix">
                  <div class="service-time">10:00 am</div>
                  <div class="service-desc">
                    Education Hour &ndash; ages 3 through teens
                  </div>
                </li>
                <li class="service-time-entry clearfix">
                  <div class="service-time">10:45 am</div>
                  <div class="service-desc">Praise Service</div>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-12">
            <div class="module-container add-container">
              <h2 class="left-bottom">Location &amp; Contact</h2>
              <p class="address">
                Emanuel Lutheran Church<br />
                150 N. Palm Street<br />
                La Habra, CA 90631<br />
                <a href="tel:+15626910656">(562) 691-0656</a>
              </p>
              <p>
                <a href="http://local.google.com/local?f=q&hl=en&q=150%20N.%20Palm%20Street,%20La%20Habra,%20CA%2090631" target="_blank">Map &amp; Directions</a>
              </p>
              <div class="map-container">
                <img src="images/home/map.gif" alt="Map to Emanuel Lutheran Church, La Habra, CA" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="photo-carousel-container">
          <div id="homePageCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#homePageCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#homePageCarousel" data-slide-to="1"></li>
              <li data-target="#homePageCarousel" data-slide-to="2"></li>
              <li data-target="#homePageCarousel" data-slide-to="3"></li>
              <li data-target="#homePageCarousel" data-slide-to="4"></li>
              <li data-target="#homePageCarousel" data-slide-to="5"></li>
              <li data-target="#homePageCarousel" data-slide-to="6"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img src="./images/home/blanket-making.jpg" alt="Blanket Making for Community Center" />
                <div class="carousel-caption">
                  <p>Blanket Making for Community Center</p>
                </div>
              </div>
              <div class="item">
                <img src="" data-img-src="./images/home/easter-sunday.jpg" alt="Easter Sunday" />
                <div class="carousel-caption">
                  <p>Easter Sunday</p>
                </div>
              </div>
              <div class="item">
                <img src="" data-img-src="./images/home/free-for-all.jpg" alt="Free-For-All" />
                <div class="carousel-caption">
                  <p>Free-For-All</p>
                </div>
              </div>
              <div class="item">
                <img src="" data-img-src="./images/home/sunday-school.jpg" alt="Science Lesson about God&rsquo;s Wonder" />
                <div class="carousel-caption">
                  <p>Science Lesson about God&rsquo;s Wonder</p>
                </div>
              </div>
              <div class="item">
                <img src="" data-img-src="./images/home/sisters-in-christ.jpg" alt="Sisters in Christ" />
                <div class="carousel-caption">
                  <p>Sisters in Christ</p>
                </div>
              </div>
              <div class="item">
                <img src="" data-img-src="./images/home/womens-retreat.jpg" alt="Women&rsquo;s retreat" />
                <div class="carousel-caption">
                  <p>Women&rsquo;s retreat</p>
                </div>
              </div>
              <div class="item">
                <img src="" data-img-src="./images/home/preschool-program.jpg" alt="Preschool Program" />
                <div class="carousel-caption">
                  <p>Preschool Program</p>
                </div>
              </div>
            </div>
          </div> <!-- /.carsousel -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="row">
          <div class="col-sm-6 col-md-12">
            <div class="module-container upcoming-events-container">
              <h2 class="right-top">Upcoming Events</h2>
              <ul class="event-list">
                <li class="event-date-entry">
                  <div class="event-calendar-container">
                    <div class="event-calendar">
                      <div class="event-calendar-month">Dec</div>
                      <div class="event-calendar-date">30</div>
                      <div class="event-calendar-day">Sunday</div>
                    </div>
                  </div>
                  <div class="event-details">
                     <div class="event-detail">
                       <div class="event-description">
                         <strong>Combined Worship Service at 10:00 AM</strong>
                       </div>
                       <div class="event-time">10 AM</div>
                     </div>
                  </div>
                </li>
                <li class="event-date-entry">
                  <div class="event-calendar-container">
                    <div class="event-calendar">
                      <div class="event-calendar-month">Jan</div>
                      <div class="event-calendar-date">18</div>
                      <div class="event-calendar-day">Friday</div>
                    </div>
                  </div>
                  <div class="event-details">
                     <div class="event-detail">
                       <div class="event-description">
                         <a href="event-fliers/2019-01-18-confirmation-youth-retreat.jpg" target="_blank">
                           <strong>Confirmation Youth Retreat</strong>
                         </a>
                         the weekend of January 18-20
                        (MLK Weekend) at Luther Glen Camp and Farm
                       </div>
                     </div>
                  </div>
                </li>
                <li class="event-date-entry">
                  <div class="event-calendar-container">
                    <div class="event-calendar">
                      <div class="event-calendar-month">Jan</div>
                      <div class="event-calendar-date">26</div>
                      <div class="event-calendar-day">Saturday</div>
                    </div>
                  </div>
                  <div class="event-details">
                     <div class="event-detail">
                       <div class="event-description">
                         <a href="event-fliers/2019-01-26-new-member-class.jpg" target="_blank">
                           <strong>New Member Class</strong>
                         </a>
                       </div>
                       <div class="event-time">10 AM</div>
                     </div>
                  </div>
                </li>
                <?php
                /*
                // example of a listing for a date with multiple events going on
                <li class="event-date-entry">
                  <div class="event-calendar-container">
                    <div class="event-calendar">
                      <div class="event-calendar-month">Dec</div>
                      <div class="event-calendar-date">24</div>
                      <div class="event-calendar-day">Sunday</div>
                    </div>
                  </div>
                  <div class="event-details">
                    <div class="event-detail">
                      <div class="event-description">Fourth Sunday of Advent Combined Service</div>
                      <div class="event-time">10 AM</div>
                    </div>
                    <div class="event-detail">
                      <div class="event-description">Christmas Eve Family Service</div>
                      <div class="event-time">7 PM</div>
                    </div>
                    <div class="event-detail">
                      <div class="event-description">Christmas Eve Candlelight Service</div>
                      <div class="event-time">11 AM</div>
                    </div>
                  </div>
                </li>
                */
                ?>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-12">
            <div class="module-container images">
              <img src="images/home/elca-transparent.gif" alt="Evangelical Lutheran Church in America" class="elca-logo" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require_once('./partials/footer.phtml') ?>
  </div>

  <?php require_once('./partials/footer-includes.phtml') ?>
  <script src="./js/home.js"></script>
</body>

</html>
