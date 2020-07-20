<?php $nav = new LDTemplate( __DIR__ ); ?>

<div id="accordion">

    <?php 
        $i = 0;
        foreach($groups as $group) {
            $group->order = $i++;
            echo $nav->render('ld-group', $group);
        }            
    ?>
    
</div>
