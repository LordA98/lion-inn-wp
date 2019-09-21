<?php
// Create template object
$tpl = new LGTemplate( __DIR__ . '/items' );
?>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Gallery Name</th>
            <th scope="col">Gallery Cover Image</th>
            <th scope="col">Images in Gallery</th>
            <th scope="col">Description</th>
            <th scope="col">Published</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($galleries as $gallery) {
                echo $tpl->render( 'lg-gallery-row' , $gallery );
            } 
        ?>
    </tbody>
</table>

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
</div>
