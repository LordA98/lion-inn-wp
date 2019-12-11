<?php
// Create template object
$tpl = new LGTemplate( __DIR__ . '/items' );
?>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Gallery Name</th>
            <th scope="col">Published</th>
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
