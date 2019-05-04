<?php 
    include( __DIR__ . "/months.php" );
    // Debugging functions
    require_once(plugin_dir_path(__DIR__) . '../../includes/le-debug.php');

    $image_id = get_option( 'myprefix_image_id' );
    le_console_log($image_id);
    if( intval( $image_id ) > 0 ) {
        // Change with the image size you want to use
        $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'myprefix-preview-image', 'class' => 'event-image' ) );
    } else {
        // Some default image
        $image = '<img id="myprefix-preview-image" src="http://localhost/lion-inn-wp/wp-content/uploads/2019/04/rugby.jpg" class="event-image" />';
    }

    $tpl = new LMTemplate( __DIR__ ); 

    $name = str_replace('\\', '', $name);

    $startdate = explode('-', $event_start_date);
    $startyear = $startdate[0];
    $startmonthnum = $startdate[1];
    $startmonth = $months[strval($startdate[1])];
    $startday = $startdate[2];

    $enddate = explode('-', $event_end_date);
    $endyear = $enddate[0];
    $endmonthnum = $enddate[1];
    $endmonth = $months[strval($enddate[1])];
    $endday = $enddate[2];
?>

<li class='list-group-item list-group-item-action' data-id='<?php echo $id; ?>'>

    <div class="row">
    
        <div class="date col-2 col-lg-1">
            <p class="month mb-0 fs-12"><?php echo $startmonth ?></p>
            <hr class="text-left bg-light my-0 hr-date"/>
            <p class="day mt-0"><?php echo $startday ?></p>

            <?php
                if($event_end_date !== "0000-00-00") {
                    echo "
                        <p class='my-2'>to</p>
                        <p class='month mb-0 fs-12'>$endmonth</p>
                        <hr class='text-left bg-light my-0 hr-date'/>
                        <p class='day mt-0'>$endday</p>
                    ";
                }
            ?>

            <span hidden class="event-start-date"><?php echo $startday . "/" . $startmonthnum . "/" . $startyear; ?></span>
            <span hidden class="event-end-date"><?php echo $endday . "/" . $endmonthnum . "/" . $endyear; ?></span>
        </div>

        <!-- Event Image -->
        <div class="image col-10 col-lg-6">
            <?php echo $image; ?>
            <input type="hidden" name="myprefix_image_id" id="myprefix_image_id" value="<?php echo esc_attr( $image_id ); ?>" class="regular-text" />
            <input type='button' class="button-primary mt-1" value="<?php esc_attr_e( 'Select Image', 'mytextdomain' ); ?>" id="myprefix_media_manager"/>
        </div> 

        <!-- <div class="image col-10 col-lg-6">
            <img src="https://media-cdn.tripadvisor.com/media/photo-s/10/e2/be/d8/angel-s-steak-pub-interior.jpg" alt="Image of the Burns Poster" class="event-image" />
        </div>    -->
        
        <div class="info col-8 offset-2 col-lg-4 offset-lg-0">
            <!-- Event Name -->
            <span class="mb-0 mt-1 mt-lg-0 event-name purple-font"><?php echo $name; ?></span>            

            <!-- Icons -->
            <div class='float-right'>
                <!-- Publish / Not Published Icon -->
                <?php
                    if($toPublish) {
                        echo $tpl->render( 'le-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published"));
                    } else {
                        echo $tpl->render( 'le-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
                    }
                ?>
                <?php echo $tpl->render( 'le-icon-link', array( "aClasses" => "edit-event", "modal" => "edit-event-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "600", "h" => "600" )); ?>
                <?php echo $tpl->render( 'le-icon-link', array( "aClasses" => "delete-event", "modal" => "delete-event-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "275", "h" => "215" )); ?>
                <!-- If it's a single day event or not -->
                <?php
                    if($isSingleDayEvent) {
                        echo "<span class='isSingleDayEvent' hidden></span>";
                    }
                ?>
            </div>

            <!-- Small Description -->
            <hr class="text-left bg-light my-1 my-lg-2 hr-desc"/>
            <p class="my-1 mt-lg-0 desc-sml"><?php echo $description_sml; ?></p>

            <!-- Large Description -->
            <hr class="text-left bg-light my-1 my-lg-2 hr-desc"/>
            <p class="desc-lrg"><?php echo $description_lrg; ?></p>
        </div>
    
    </div>

</li>

