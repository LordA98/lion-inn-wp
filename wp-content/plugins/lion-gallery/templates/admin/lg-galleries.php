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
    
    <?php 
        foreach($galleries as $gallery) {
            // echo $tpl->render( 'lg-' , $gallery );
            echo print_r($gallery);
            echo "<br/><br/>";
        } 
    ?>
</div>
