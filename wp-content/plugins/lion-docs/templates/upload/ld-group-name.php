<?php $tpl = new LDTemplate( __DIR__ ); ?>

<div class="row" id="<?php echo $group->id; ?>">
  <div class="align-self-center mx-3">
    <?php
      if($type == 'group') { ?>
        <span class="badge badge-success my-auto">Group</span>
    <?php } else { ?>
        <span class="badge badge-primary my-auto">Subgroup</span>
    <?php } ?>    
  </div>
  <div>
    <?php
      if($type == 'group') { ?>
        <h2 class="group-name d-inline"><?php echo $group->name; ?></h2>
    <?php } else { ?>
        <h4 class="group-name d-inline"><?php echo $group->name; ?></h4>
    <?php } ?>
  </div>
  <div class="align-self-center mx-3">    
    <span class="publish-group">
      <span class="publish-value" data-id="<?php echo $group->toPublish; ?>" hidden><?php echo $group->toPublish; ?></span>
      <?php
          if($group->toPublish) {
              echo $tpl->render( 'ld-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published"));
          } else {
              echo $tpl->render( 'ld-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
          }
      ?>
    </span>    
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "edit-group", "modal" => "edit-group-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "500", "h" => "420" )); ?>
    <?php echo $tpl->render( 'ld-icon-link', array( "aClasses" => "delete-group", "modal" => "delete-group-modal", "tooltip" => "Delete", "iClasses" => "fa-trash-alt", "w" => "300", "h" => "225" )); ?>
  </div>
</div>
