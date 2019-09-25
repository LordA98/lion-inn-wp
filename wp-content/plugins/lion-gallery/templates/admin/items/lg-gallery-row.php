<?php $tpl = new LGTemplate( __DIR__ ); ?>

<tr id="<?php echo $id; ?>">
    <th scope="row"><?php echo $id; ?></th>
    <td class="gallery-name"><?php echo $title; ?></td>
    <td class="publish-gallery">
        <div class="publish-value" data-id="<?php echo $toPublish; ?>" hidden><?php echo $toPublish; ?></div>
        <?php
            if($toPublish) {
                echo $tpl->render( 'lg-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published"));
            } else {
                echo $tpl->render( 'lg-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
            }
        ?>
    </td>
    <td>
    <?php echo $tpl->render( 'lg-icon-link', array( "aClasses" => "edit-gallery", "modal" => "edit-gallery-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "500", "h" => "420" )); ?>
    </td>
    <td>
    <?php echo $tpl->render( 'lg-icon-link', array( "aClasses" => "delete-gallery", "modal" => "delete-gallery-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "275", "h" => "215" )); ?>
    </td>
</tr>