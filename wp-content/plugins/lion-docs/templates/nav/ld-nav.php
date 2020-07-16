<?php $nav = new LDTemplate( __DIR__ ); ?>

<div id="accordion">

    <?php 
        foreach($groups as $group) { 
            echo $nav->render('ld-group', $group);
        }            
    ?>
    
</div>
