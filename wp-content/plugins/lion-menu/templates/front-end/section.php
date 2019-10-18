<?php 
    $tpl = new LMTemplate( __DIR__ );

    $name = str_replace('\\', '', $name);    
?>

<div class="mt-5">

    <h1 class="great-vibes m-0"><?php echo $name; ?></h1>

    <?php

        /**
         * Print Items in section
         */

        $db = new LMSQLManager();

        $items = $db->get( "item" , array( "parent_section" => $id, "toPublish" => 1 ));

        echo $tpl->render( 'list' , array( "listOf" => $items,  "type" => "ITEMS", "classes" => "", "side" => $side ));    

    ?>

</div>