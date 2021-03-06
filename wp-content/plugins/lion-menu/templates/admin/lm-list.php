<?php 
    /**
     * Handle List Generation on Admin Pages
     * Lists are JQuery Sortable Lists
     * 
     * TODO - document all possible $var's that can be passed to this template
     * (to prevent any confusion in future)
     */

    $tpl = new LMTemplate( __DIR__ . '/items' );
?>

<ol class='<?php echo $classes; ?>'>

    <?php

        switch($type) {

            case "MENUS":
                foreach($listOf as $menu) {
                    echo $tpl->render( 'lm-menu' , $menu );
                }
                break;

            case "SECTIONS":                       
                foreach($listOf as $sec) {
                    if($sec->side == $side) {
                        $sec->isParentPublished = $isParentPublished;
                        echo $tpl->render( 'lm-section' , $sec );
                    }
                }
                break;

            case "ITEMS":
                if(!$listOf) {
                    echo "<i class='fs-10'>No items.</i>";                    
                } else {
                    foreach($listOf as $item) {
                        $item->isParentPublished = $isParentPublished;
                        echo $tpl->render( 'lm-item' , $item );                   
                    }
                }             
                break;

            case "SUBITEMS":
                if(!$listOf && !$isSubsec && !$isNote) {  
                    echo "<i class='fs-10'>No subitems.</i>";
                } else {
                    foreach($listOf as $subitem) {
                        $subitem->isParentPublished = $isParentPublished;
                        echo $tpl->render( 'lm-subitem' , $subitem );
                    }
                }
                break;

        } 

    ?>

</ol>