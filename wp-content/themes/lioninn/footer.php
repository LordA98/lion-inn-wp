<div class="container-fluid footer-bg">
    <div class="container">

        <div id="footer" class="footer py-2">
            <div class="row contact text-center">
                <div class="col-4 order-lg-1 col-lg-1 offset-lg-2">
                    <i class="fas fa-phone mt-2"></i>
                    <p class="mb-0 mt-1">
                        <?php the_field('phone_number'); ?>
                    </p>
                </div>
                <div class="col-4 order-lg-2 col-lg-1">
                    <i class="fas fa-envelope mt-2"></i>
                    <p class="mb-0 mt-1 overflow">
                        <?php the_field('email_address'); ?>
                    </p>
                </div>
                <div class="col-4 order-lg-3 col-lg-1">
                    <i class="fas fa-map-marker-alt mt-2"></i>
                    <a href="https://maps.google.com/?q=51.7460885,-2.7240651&t=m" target="_blank">
                        <p class="mb-0 mt-1">Get Directions</p>
                    </a>
                </div>
                <div class="col-12 order-first order-lg-4 col-lg-2 algeria d-flex flex-column">
                    <h2 class="my-auto">THE LION INN</h2>
                </div>
                <div class="col-4 order-lg-5 col-lg-1">
                    <a href="#">
                        <i class="fab fa-google mt-2"></i>
                    </a>
                    <p class="mb-0 mt-1">Google</p>
                </div>
                <div class="col-4 order-lg-6 col-lg-1">
                    <a href="https://www.tripadvisor.co.uk/Restaurant_Review-g552009-d732964-Reviews-Lion_Inn-Monmouth_Monmouthshire_South_Wales_Wales.html">
                        <i class="fab fa-tripadvisor mt-2"></i>
                    </a>
                    <p class="mb-0 mt-1">TripAdvisor</p>
                </div>
                <div class="col-4 order-lg-7 col-lg-1">
                    <a href="https://www.facebook.com/TheLionInnTrellech/">
                        <i class="fab fa-facebook mt-2"></i>
                    </a>
                    <p class="mb-0 mt-1">Facebook</p>
                </div>
            </div>

            <div class="copyright text-center mt-3">
                <p class="mb-0">
                    <?php the_field('copyright'); ?>
                </p>
            </div>
        </div>
    </div> <!-- Container -->

</div> <!-- Container Fluid -->

<?php wp_footer(); ?>
