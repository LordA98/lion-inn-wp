<?php $tpl = new LGTemplate( __DIR__ ); ?>

<tr id="<?php echo $id; ?>">
    <th scope="row"><?php echo $id; ?></th>
    <td class="gallery-name"><?php echo $title; ?></td>
    <td class="publish-gallery">
        <div class="publish-value" data-id="<?php echo $toPublish; ?>" hidden><?php echo $toPublish; ?></div>
        <?php
            if($toPublish) {
                echo $tpl->render( 'lg-toggle', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published", "colour" => "btn-success" ));
            } else {
                echo $tpl->render( 'lg-toggle', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published", "colour" => "btn-danger" ));
            }
        ?>
    </td>
</tr>