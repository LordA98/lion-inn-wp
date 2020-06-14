<?php $tpl = new LDTemplate( __DIR__ ); ?>

<div class="row" id="<?php echo $group->id; ?>">
  <div class="align-self-center mx-3">
    <span class="badge badge-success my-auto">Group</span>
  </div>
  <div>
    <?php
      if($heading == 'h2') { ?>
        <h2 class="group-name d-inline"><?php echo $group->name; ?></h2>
    <?php } else { ?>
        <h4 class="group-name d-inline"><?php echo $group->name; ?></h4>
    <?php } ?>
  </div>
  <div class="align-self-center mx-3">      
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "edit-group", "modal" => "edit-group-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "500", "h" => "420" )); ?>
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "delete-group", "modal" => "delete-group-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "300", "h" => "225" )); ?>
  </div>
</div>
