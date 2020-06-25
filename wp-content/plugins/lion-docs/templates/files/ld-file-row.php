<?php $tpl = new LDTemplate( dirname(__DIR__, 1) . "/shared" ); ?>

<tr id="<?php echo $id; ?>">
    <th scope="row"><?php echo $id; ?></th>
    <td class="filename"><?php echo $name; ?></td>
    <td>
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "delete-file", "modal" => "delete-file-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "275", "h" => "215" )); ?>
    </td>
</tr>