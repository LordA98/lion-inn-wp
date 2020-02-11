<?php 
    $icon_tpl = new LMTemplate( __DIR__ );
    $list_tpl = new LMTemplate( plugin_dir_path( __DIR__ ) );

    $bg = '';

    // Set background colours and subitem bools
    if($type == 'subtitle') {
        $bg = 'purpleBg white-font';
        $isSubsectionTitle = 1;
        $isNote = 0;
    } else if($type == 'note') {
        $bg = 'bg-primary white-font';
        $isSubsectionTitle = 0;
        $isNote = 1;
    } else {
        $isSubsectionTitle = 0;
        $isNote = 0;
    }

    $name = str_replace('\\', '', $name);
    $description = str_replace('\\', '', $description);
?>

<li class="list-group-item list-group-item-action no-position item <?php echo $bg; ?>" data-id="<?php echo $id; ?>" data-name="<?php echo $name; ?>">

    <!-- Hamburger -->
    <i class="fas fa-bars"></i>
    <!-- Item Name -->
    <span class="ml-3 item-name"><?php echo $name; ?></span>

    <!-- Icons -->
    <div class='float-right'>
        <!-- 
        Publish / Not Published Icon 
        Refer to lm-section.php comment for explanation of below if else.
        -->
        <?php
        if(!$isParentPublished) {
            $publishClass = ($toPublish ? 'toPublish' : '');
            echo $icon_tpl->render( 'lm-icon', array( "classes" => "fas fa-times-circle $publishClass mr-3", "tooltip" => "Not Published"));
            $toPublish = $isParentPublished;
        } else if($toPublish) {
            echo $icon_tpl->render( 'lm-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published"));
        } else {
            echo $icon_tpl->render( 'lm-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
        }
        ?>
        <?php echo $icon_tpl->render( 'lm-icon-link', array( "aClasses" => "add-subitem", "modal" => "add-subitem-modal", "tooltip" => "Add Subitem", "iClasses" => "fa-plus mr-3", "w" => "550", "h" => "350" )); ?>
        <?php echo $icon_tpl->render( 'lm-icon-link', array( "aClasses" => "edit-item", "modal" => "edit-item-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "550", "h" => "500" )); ?>
        <?php echo $icon_tpl->render( 'lm-icon-link', array( "aClasses" => "delete-item", "modal" => "delete-item-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "275", "h" => "215" )); ?>
        <!-- Hidden isSubsection - Needed for Form Autofill -->
        <?php if($type == 'subtitle') { echo "<span class='isSubsec' hidden></span>"; } ?>
        <!-- Hidden isNote - Needed for Form Autofill -->
        <?php if($type == 'note') { echo "<span class='isNote' hidden></span>"; } ?>
    </div>  

    <!-- Description -->
    <div class="row ml-3 desc">
        <i class="ml-3 fs-10"><?php echo $description; ?></i>
    </div>

    <!-- Veggie, Gluten and Price -->
    <div class="row ml-3 d-flex w-75 veg-gf-price">
        <div class="ml-3 veg-gf">
            <?php 
            if($isVegetarian) {
                echo "<img class='mx-2 icon veg-icon' src='". plugins_url() . '/lion-menu/assets/images/vegetarian.png' . "' alt='Image of Vegetarian Icon' />";
            }
            if($isGlutenFree) {
                echo "<img class='mx-2 icon gf-icon' src='". plugins_url() . '/lion-menu/assets/images/gluten-free.png' . "' alt='Image of Gluten Free Icon' />";
            }
            if($isVegan) {
                echo "<img class='mx-2 icon gf-icon' src='". plugins_url() . '/lion-menu/assets/images/vegan.png' . "' alt='Image of Vegan Icon' />";
            } 
            ?>
        </div>

        <?php 
        if((!is_null($price)) && ($price !== "0.00")) {
            echo "<p class='fs-14 ml-auto price'>£$price</p>";
        }
        ?>
    </div>

    <!-- Subitems -->
    <?php

    $db = new LMSQLManager();

    $subitems = $db->get( "subitem" , array ( "parent_item" => $id ) );

    echo $list_tpl->render( 'lm-list' , array( "listOf" => $subitems,  "type" => "SUBITEMS", "isParentPublished" => $toPublish, "classes" => "list-group subitems-list", "isSubsec" => $isSubsectionTitle, "isNote" => $isNote ));

    ?>

</li>