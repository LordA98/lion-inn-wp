<?php $shared = new LDTemplate( dirname(__DIR__, 1) . "/shared" ); ?>

<div id="<?php echo $def_id; ?>">
  <div class="p-4 bg-light mb-5">
    <h4>Default File:</h4>

    <span class="mr-3"><?php echo $name; ?> // <?php echo $title; ?> // <?php echo $filename; ?></span>
    <?php echo $shared->render( 'ld-icon-link', array( "aClasses" => "edit-default", "modal" => "edit-default-modal", "tooltip" => "Edit", "iClasses" => "fa-edit mr-3", "w" => "500", "h" => "200" )); ?>

  </div>
</div>
