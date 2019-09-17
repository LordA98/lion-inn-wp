<?php
// Create template object
$tpl = new LGTemplate( __DIR__ . '/items' );
?>

<div class='container-fluid'>

    <!-- List of Galleries (sortable list?) (list of lg-gallery.php) -->
    <!-- Each Gallery item has:
            Gallery Image
            Name
            Publish
            Image Count
            Description
            Edit
            Delete
    -->
    
    <?php echo $galleries; ?>
</div>
