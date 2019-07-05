<?php $tpl = new LDTemplate( __DIR__ ); ?>

<tr>
    <th scope="row"><?php echo $id; ?></th>
    <td><?php echo $title; ?></td>
    <td><?php echo $filename; ?></td>
    <td><?php echo $section; ?></td>
    <td><?php echo $parent_doc; ?></td>
    <td><?php echo $views; ?></td>
    <td>
        <?php
            if($toPublish) {
                echo $tpl->render( 'ld-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published"));
            } else {
                echo $tpl->render( 'ld-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
            }
        ?>
    </td>
</tr>