<?php $tpl = new LDTemplate( __DIR__ ); ?>

<tr id="<?php echo $id; ?>">
    <th scope="row"><?php echo $id; ?></th>
    <td class="doc-name"><?php echo $title; ?></td>
    <td class="filename"><?php echo $filename; ?></td>
    <td class="section"><?php echo $section; ?></td>
    <td class="parent-doc"><?php echo $parent_doc; ?></td>
    <td><?php echo $views; ?></td>
    <td class="publish-doc">
        <div class="publish-value" data-id="<?php echo $toPublish; ?>" hidden><?php echo $toPublish; ?></div>
        <?php
            if($toPublish) {
                echo $tpl->render( 'ld-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published"));
            } else {
                echo $tpl->render( 'ld-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
            }
        ?>
    </td>
    <td>
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "edit-doc", "modal" => "edit-doc-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "500", "h" => "420" )); ?>
    </td>
    <td>
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "delete-doc", "modal" => "delete-doc-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "275", "h" => "215" )); ?>
    </td>
</tr>