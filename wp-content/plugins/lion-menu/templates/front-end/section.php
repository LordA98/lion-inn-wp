<?php $tpl = new Template( __DIR__ ); ?>

<div class="<?php echo $classes; ?>">

    <h1 class="great-vibes m-0"><?php echo $name; ?></h1>
    <hr class="mt-2"/>

    <!-- Print Items in Section -->
    <?php

    $db = new SQLManager();

    $items = $db->get( "item" , array( "parent_section" => $id, "toPublish" => 1 ));

    echo $tpl->render( 'list' , array( "listOf" => $items,  "type" => "ITEMS", "classes" => "" ));    

    ?>

</div>