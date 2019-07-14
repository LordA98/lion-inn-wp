<?php
/**
 * Template Name: Home
 */

if (class_exists( 'LionEvents' )) {

    $lionMenu = new LionEvents();

} else {

    echo "<h3>Class doesn't exist (i.e. plugin not installed or something).</h3>";
    log_me("ERROR :- LionEvents Class does not exist.  Object cannot be created.");
    console_log("LionEvents class tried to create but failed - class doesn't exist.");

}
?>

<!-- Built in WordPress function to get 'header.php' -->
<?php get_header(); ?>

<body class="montserrat" data-spy="scroll" data-target="#navbar-main">

    <!-- Background image at top of page -->
    <div class="home-bg-image"></div>

    <div class="container">
        <!-- Home section / landing page -->
        <div id="home" class="home p-0 d-flex flex-column" style="color: #FFF;">
            <!-- Header - logo and nav -->
            <nav id="navbar-main" class="header navbar navbar-expand-xl mb-5 pt-3 row fixed-top">
                <!-- Logo -->
                <a class="navbar-brand mr-0 p-0 pl-3 pl-xl-0 col-6 col-xl-1 offset-xl-2" href="#home">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/logo.png" width="75px" height="75px" alt="The Lion Inn Logo" />
                </a>
                <!-- Hamburger for smaller screens -->
                <div class="hamburger-container col-6 text-right p-0 d-xl-none">
                    <button class="navbar-toggler" id="hamburger" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars" style="font-size:40pt; color:#FFF;"></i>
                    </button>
                </div>

                <div class="collapse navbar-collapse col-xl-6 p-0" id="navbarSupportedContent">
                    <ul class="navbar-nav row justify-content-center">
                        <li class="nav-item mr-xl-5 collapse-purple">
                            <a class="nav-link enabled pl-5 pt-xl-2 pl-xl-2 d-flex flex-column" href="#about-us">
                                <span class="my-auto">About Us</span>
                            </a>
                        </li>
                        <li class="nav-item mr-xl-5 collapse-white">
                            <a class="nav-link enabled pl-5 pt-xl-2 pl-xl-2 d-flex flex-column" href="#food">
                                <span class="my-auto">Food</span>
                            </a>
                        </li>
                        <li class="nav-item mr-xl-5 collapse-purple">
                            <a class="nav-link enabled pl-5 pt-xl-2 pl-xl-2 d-flex flex-column" href="#accommodation">
                                <span class="my-auto">Accommodation</span>
                            </a>
                        </li>
                        <li class="nav-item mr-xl-5 collapse-white">
                            <a class="nav-link enabled pl-5 pt-xl-2 pl-xl-2 d-flex flex-column" href="#events">
                                <span class="my-auto">Events</span>
                            </a>
                        </li>
                        <li class="nav-item mr-xl-5 collapse-purple">
                            <a class="nav-link disabled pl-5 pt-xl-2 pl-xl-2 d-flex flex-column" href="#gallery">
                                <span class="my-auto">Gallery</span>
                            </a>
                        </li>
                        <li class="nav-item collapse-hide">
                            <a class="nav-link enabled" href="#footer">Contact Us</a>
                        </li>
                        <!-- Footer just for mobile hamburger -->
                        <div class="footer mobile-footer py-2">
                            <div class="row contact text-center">
                                <div class="col-4 order-xl-1 col-xl-1 offset-xl-2">
                                    <i class="fas fa-phone mt-2"></i>
                                    <p class="mb-0 mt-1">01600 860322</p>
                                </div>
                                <div class="col-4 order-xl-2 col-xl-1">
                                    <i class="fas fa-envelope mt-2"></i>
                                    <p class="mb-0 mt-1">debs@globalnet.co.uk</p>
                                </div>
                                <div class="col-4 order-xl-3 col-xl-1">
                                    <i class="fas fa-map-marker-alt mt-2"></i>
                                    <p class="mb-0 mt-1">Get Directions</p>
                                </div>
                                <div class="col-12 order-first order-xl-4 col-xl-2 algeria">
                                    <h3>THE LION INN</h3>
                                </div>
                                <div class="col-4 order-xl-5 col-xl-1">
                                    <a href="#">
                                        <i class="fab fa-google mt-2"></i>
                                    </a>
                                    <p class="mb-0 mt-1">Google</p>
                                </div>
                                <div class="col-4 order-xl-6 col-xl-1">
                                    <a href="https://www.tripadvisor.co.uk/Restaurant_Review-g552009-d732964-Reviews-Lion_Inn-Monmouth_Monmouthshire_South_Wales_Wales.html">
                                        <i class="fab fa-tripadvisor mt-2"></i>
                                    </a>
                                    <p class="mb-0 mt-1">TripAdvisor</p>
                                </div>
                                <div class="col-4 order-xl-7 col-xl-1">
                                    <a href="https://www.facebook.com/TheLionInnTrellech/">
                                        <i class="fab fa-facebook mt-2"></i>
                                    </a>
                                    <p class="mb-0 mt-1">Facebook</p>
                                </div>
                            </div>

                            <div class="copyright text-center mt-3 px-2">
                                <p class="mb-0">Copyright &copy; 2004 - 2018 All Content of this site is property of The Lion Inn and must not be reproduced without permission.  Every effort is made to ensure the details contained on this site are correct.  However, we cannot accept responsibility for errors and omissions.</p>
                            </div>
                        </div> <!-- End Footer -->
                    </ul>
                </div>

                <!-- Empty column-1 to center nav elements -->
                <div class="col-lg-1"></div>
            </nav>

            <div class="my-auto">
                <div class="center row">
                    <div class="col-xl-12 text-center mt-5 mb-3">
                        <h1 class="great-vibes m-0 mr-3 main-heading">Welcome</h1>
                        <h4 class="m-0 to">to</h4>
                        <h1 class="algeria m-0 main-heading w-100">THE LION INN</h1>
                    </div>
                </div>

                <div class="buttons row">
                    <div class="col-3 col-sm-2 offset-sm-2 col-md-2 offset-md-2 col-lg-2 offset-lg-3 col-xl-1 offset-xl-4 p-0 pr-lg-2 px-xl-0 text-right">
                        <button type="button" class="btn btn-transparent btn-lg p-0 py-sm-2 px-3 m-xl-0">
                            <a href="#food">
                                <i class="fas fa-utensils btn-icon"></i>
                            </a>
                        </button>
                    </div>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xl-2 offset-xl-0 p-0 text-center">
                        <button type="button" class="btn btn-lg py-1 px-2 btn-phone">
                            <span class="phone-no">01600 860322</span>
                        </button>
                    </div>
                    <div class="col-3 col-sm-4 col-md-2 col-lg-2 col-xl-1 p-0 pl-lg-2 px-xl-0 text-md-left">
                        <button type="button" class="btn btn-transparent btn-lg p-0 py-sm-2 px-3 m-xl-0">
                            <a href="#accommodation">
                                <i class="fas fa-bed btn-icon"></i>
                            </a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="arrow row mt-auto mb-4">
                <div class="col-12 text-center">
                    <a href="#food">
                        <i class="fas fa-arrow-circle-down btn-icon"></i>
                    </a>
                </div>
            </div>
        </div>

    </div> <!-- Container -->

    <!-- About Us -->
    <div class="container">

        <div id="about-us" class="about-us mt-5">

            <div class="row">

                <!-- Text -->
                <div id="left-content" class="col-lg-6 col-xl-5 offset-xl-1 text-center pt-4 bg-white">

                    <div class="title">
                        <h1 class="great-vibes section-heading">About Us</h1>
                    </div>

                    <div class="pt-3 px-4">
                        <p>
                            Situated in Monmouthshire, in the heart of the picturesque Wye Valley, South Wales.  
                            The Lion Inn is a well established and extremely popular public house.
                        </p>
                        <p>
                            Built in the late 16th Century, actually completed in 1580, The Lion Inn was originally a coaching inn, brew house and pig farm.
                            Many of the original features of the brewing cellar still remain, as do a number of outhouses that were used as pig sty's.
                        </p>
                        <p>
                            The Lion Inn is the only traditional inn in the ancient village of Trellech.  It consists
                            of two rooms, both with open fires and exposed wooden beams.  One room is used as a traditional
                            village bar, the other as a restaurant area.
                        </p>
                        <p>
                            The pub stocks a fine range of real ales and ciders, as well as the traditional range of keg Lager,
                            Bitters, Ciders, Guiness and Spirits including a large range of whiskies, Gins and Rums.
                        </p>
                        <p>
                            The whole emphasis of the pub is towards the traditional - Traditional Beers, Real Ciders, Quality
                            Home Made Food and a Friendly atmosphere.
                        </p>
                    </div>
                </div>

                <!-- Image -->
                <div id="right-content" class="col-lg-6 col-xl-5 p-4 bg-white text-center text-lg-left">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/pub_original.jpg" alt="Image of The Lion Inn" class="mt-lg-5 ml-xl-4 mt-xl-0 about-us-image" />
                </div>
                
            </div>
            
        </div>

    </div> <!-- Container -->

    <!-- Background image for FOOD section -->
    <div class="food-bg-image"></div>

    <!-- Food -->
    <div class="container">

        <div id="food" class="food my-5">

            <div class="title text-center col-12">
                <h1 class="great-vibes section-heading">Food</h1>
            </div>

            <div class="menu row">
                <div class="left col-lg-6 offset-lg-1 text-center">
                    <h2 class="great-vibes minor-heading">Menu</h2>
                    <div class="mt-3 desc">
                        <p>
                            The menus range from traditional pub grub, through to the exotic and unheard of; with children and vegetarians being catered for. Sourcing the majority of the produce within 10 miles of the pub.  For example, the meats come from the local communities of Shirenewton, Raglan & Trellech.  A "standard" menu is provided within the pub along with a number of "specials" menus.
                        </p>
                        <p>
                            The specials boards change regularly and often feature dishes that offer new eating experiences for more adventurous diners. Regular favourites include Beef Stroganoff, Chicken in a creamy Tarragon sauce, Kangaroo steak, Ostrich with a creamy garlic sauce, Pork steak with a cider sauce and Duck.
                        </p>
                        <p>
                            Special menu’s are created for Easter Sunday and Mother’s Day.  Takeaway pizza’s are also available.
                        </p>
                    </div>
                    <a class="btn btn-sm mt-3" href="menu">
                        <span class="px-1">View Menu</span>
                    </a>
                </div>

                <div class="right col-lg-3 offset-lg-1" style="overflow: hidden; position: relative; width: 100%;">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/menu.png" alt="Image of Menu" style="background:green; height: 100%; width: auto; position: absolute; right: 0; top: 0; object-fit: cover;" />
                </div>
            </div>

            <div class="book-table row mt-5">
                <div class="times col-lg-4 text-center py-4">
                    <h2 class="great-vibes minor-heading">Times</h2>
                    <i class="far fa-clock"></i>
                    <div class="opening-times">
                        <h4 class="mt-3 times-heading">Opening Times</h4>
                        <hr class="bg-light mx-auto mt-0"/>
                        <p>
                            Monday - Wednesday <br/>
                            12:00 - 23:00 <br/>
                            Thursday - Saturday <br/>
                            12:00 - 00:00 <br/>
                            Sunday <br/>
                            12:00 - 22:00
                        </p>
                    </div>
                    <div class="dining-times">
                        <h4 class="mt-3 times-heading">Dining Times</h4>
                        <hr class="bg-light mx-auto mt-0"/>
                        <p>
                            Monday - Saturday <br/>
                            12:00 - 21:30 <br/>
                            Sunday <br/>
                            12:00 - 18:00
                        </p>
                    </div>
                </div>

                <div class="reservation col-lg-8 text-center pt-4 bg-white">
                    <h2 class="great-vibes minor-heading">Reservation</h2>
                    <i class="fas fa-book-open"></i>
                    <h4 class="mt-3">Please call us on the number below.</h4>
                    <p class="mt-5">
                        Please mention any special dietary requirements <br/>
                        (vegetarian, gluten free, peanut allergy).
                    </p>
                    <p>
                        Please also mention if you are bringing a dog.
                    </p>
                    <div class="icons mt-4">
                        <img class="mx-2" src="<?php echo get_bloginfo('template_directory'); ?>/images/pet-friendly.png" alt="Image of Pet Friendly Icon" />
                        <img class="mx-2" src="<?php echo get_bloginfo('template_directory'); ?>/images/vegetarian.png" alt="Image of Vegetarian Icon" />
                        <img class="mx-2" src="<?php echo get_bloginfo('template_directory'); ?>/images/gluten-free.png" alt="Image of Gluten Free Icon" />
                    </div>
                    <div class="book-now mt-4 mb-lg-0 mb-3">
                        <h4 class="great-vibes mb-0">Book Now</h4>
                        <button type="button" class="btn btn-lg mt-4 py-1 px-3">
                            <span>01600 860322</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>        
    </div> <!-- Container -->

    <div class="container">
        <div id="accommodation" class="accommodation">
            <div class="title text-center">
                <h1 class="great-vibes section-heading">Accommodation</h1>
            </div>

            <div class="cottage row">
                <div class="col-12 col-xl-6 text-center">
                    <h2 class="great-vibes minor-heading">Cottage</h2>
                    <div class="px-md-5">
                        <p>The Lion Inn Cottage was originally an Elizabethan stone pig cot.</p>
                        <p>
                            The cottage has been tastefully decorated in a traditional country style and can sleep a family of four.
                            The open plan room is enhanced by skylights and contains a double bed and double sofa bed.
                        </p>
                        <p>
                            The luxurious marble tiled bathroom contains a spacious shower unit.
                            The fully equipped compact kitchen has been made to measure and boasts a traditional Belfast sink, double hob,
                            microwave and refigerator.  Central heating (supplied by new slim-line storage heaters) and a carpeted floor
                            ensure the cottage is cosy all year around.
                        </p>
                        <p>
                            To the front of the cottage a walled patio ensures privacy
                            and is a sun trap during warmer weather.  A welcome pack is available and packed lunches can be provided at a 
                            small cost, if requested.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-xl-6 p-4">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/stock-accomm.jpg" alt="Image of Bed" class="cottage-img">
                </div>
            </div>

            <div class="cards text-center mt-4 row">
                <div class="col-xl-4 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="great-vibes card-header">B&B</div>
                        <div class="card-body px-5">
                            <p class="card-text">
                                Low Season £70 per night. <br/>
                                High Season £80 per night. <br/>
                                Prices assume 2 people sharing.
                            </p>
                            <p class="card-text">
                                All year £58 per night 1 person.
                            </p>
                            <p class="card-text">
                                Well behaved dogs welcome £2.50 per dog per day.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="great-vibes card-header">Self-Catering</div>
                        <div class="card-body px-5">
                            <p class="card-text">
                                Low Season £50 per night. <br/>
                                High Season £60 per night.  <br/>
                            </p>
                            <p class="card-text">
                                Self Catering Tariff we provide bedding only, you <br/>
                                provide towels, food, etc. <br/>
                                Packed lunches can be provided.  <br/>
                                £9.00 each includes sandwiches, soft drink, fruit, chocolate & crisps.  <br/>
                                Towels can be hired at £5.00 each.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="great-vibes card-header">Season Dates</div>
                        <div class="card-body px-5">
                            <p class="card-text">
                                High Season <br/>
                                May - September <br/>
                                Decemeber 22nd - January 5th inclusive
                            </p>
                            <p class="card-text">
                                Low Season <br/>
                                October - April
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="phone-number text-center mt-5">
                <div class="book-now mt-4 mb-lg-0 mb-3">
                    <h4 class="great-vibes mb-0">Book Now</h4>
                    <button type="button" class="btn btn-lg mt-4 py-1 px-3">
                        <span>01600 860322</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Container fluid used just so that I can have full width background -->
    <div class="container-fluid bg-light pb-4">
        <div class="container">

            <div id="events" class="events mt-5 pt-5">
                <div class="title text-center">
                    <h1 class="great-vibes section-heading">Events</h1>
                </div>
                <!-- NOTE - use toggleable tabs for regular events section -->
                <div class="regular">
                    <h2 class="montserrat row event-sub-heading mb-0">Regular Events</h2>
                    <hr class="row mt-2"/>
                    <!-- Day Titles -->
                    <div class="row week-days week-days-titles">
                        <div class="col-1 p-0">Monday</div>
                        <div class="col-1 p-0">Tuesday</div>
                        <div class="col-1 p-0">Wednesday</div>
                        <div class="col-1 p-0">Thursday</div>
                        <div class="col-1 p-0">Friday</div>
                        <div class="col-1 p-0">Saturday</div>
                        <div class="col-1 p-0">Sunday</div>
                    </div>

                    <!-- Clickable Tabs -->
                    <ul class="nav nav-tabs row week-days text-center" id="myTab" role="tablist">
                        
                        <?php

                        if(method_exists($lionEvents, 'render_r_events_nav')) {

                            $lionEvents->render_r_events_nav();

                        } else {

                            echo "<h3>Error loading events nav.</h3>";
                            log_me("ERROR :- LionEvents regular events nav could not be loaded.");
                            console_log("Error loading regular events nav.");

                        }

                        ?>
                        
                    </ul>

                    <!-- Event information -->
                    <div class="tab-content row week-days" id="myTabContent" style="background-color: #FFF;">
                        <div class="col-1"></div> <!-- Empty div to help format page - align event info -->

                        <?php

                        if(method_exists($lionEvents, 'render_r_events')) {

                            $lionEvents->render_r_events();

                        } else {

                            echo "<h3>Error loading regular events.</h3>";
                            log_me("ERROR :- LionEvents regular events could not be loaded.");
                            console_log("Error loading events.");

                        }

                        ?>
                        
                    </div>

                </div>

                <div class="upcoming mt-5 mb-0 pb-0">
                    <h2 class="row montserrat event-sub-heading mb-0">Upcoming Events</h2>
                    <hr class="row mt-2"/>

                    <?php

                        if(method_exists($lionEvents, 'render_events')) {

                            $lionEvents->render_events();

                        } else {

                            echo "<h3>Error loading upcoming events.</h3>";
                            log_me("ERROR :- LionEvents upcoming events could not be loaded.");
                            console_log("Error loading events.");

                        }

                    ?>

                </div>
            </div>

        </div> <!-- Container -->

    </div> <!-- Container Fluid -->

    <!-- Built in WordPress function to get 'footer.php' -->
    <?php get_footer(); ?>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Custom JS -->
    <script src="<?php echo get_bloginfo('template_directory'); ?>/script.js"></script>
</body>
</html>
