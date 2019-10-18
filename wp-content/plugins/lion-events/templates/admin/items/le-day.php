<?php 
    $tpl = new LETemplate( __DIR__ ); 
    
    $title = str_replace('\\', '', $title);
    
    $description = str_replace('\\', '', $description);
?>

<div class="card m-0 p-0 col-8">

    <!-- Day Button -->
    <div class="r-event-day card-header bg-white p-0" id="<?php echo strtolower($day); ?>">
        <div>
            <button class="btn btn-link r-event-day-text py-3 text-left w-100 h-100" type="button" data-toggle="collapse" data-target="#<?php echo $day . $id; ?>" aria-expanded="true" aria-controls="<?php echo $day . $id; ?>">
                <?php echo $day; ?>
            </button>            
        </div>
    </div>

    <!-- Content for that day's event -->
    <div id="<?php echo $day . $id; ?>" class="collapse r-event-body hide pl-4" aria-labelledby="<?php echo strtolower($day); ?>" data-parent="#regular-events">
        <div class="card-body">
            <div class="row">
                <!-- Icon -->
                <?php echo $tpl->render( 'le-r-event-icon', array('id' => $id, 'icon_url' => $icon_url, 'name' => $day)); ?>
                <!-- Event Title -->
                <h3 class="title"><?php echo $title; ?></h3>
                <!-- Icons -->
                <div class="mt-1 ml-3" data-id="<?php echo $id; ?>">
                    <?php echo $tpl->render( 'le-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published")); ?>            
                    <?php echo $tpl->render( 'le-icon-link', array( "aClasses" => "edit-r-event", "modal" => "edit-r-event-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "600", "h" => "500" )); ?>
                </div>
            </div>
            <!-- Event Description -->
            <!-- $description gets printed in <p> tags as they are included in the DB string -->
            <div class="row description">
                <?php echo $description; ?>
            </div>
        </div>
    </div>

</div>
