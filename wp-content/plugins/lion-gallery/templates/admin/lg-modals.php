<?php $tpl = new LGTemplate( __DIR__ . '/forms' ); ?>

<!-- Add Gallery Modal -->
<div id="add-gallery-modal" style="display:none;">

    <form action="#" method="post" class="gallery-form">
        <h3 class="mb-4">Add Gallery</h3>
        <input type="hidden" name="add-gallery" /> 
        <?php echo $tpl->render( 'lg-text-input', array( "id" => "gallery-name-input", "name" => "gallery-name", "label" => "Gallery Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lg-textarea-input', array( "id" => "desc-input", "name" => "gallery-desc", "label" => "Description" )); ?>
        <?php echo $tpl->render( 'lg-checkbox-input', array( "id" => "publish-gallery-check", "name" => "publish-gallery", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'lg-form-buttons', array( "value" => "Add" )); ?>
    </form>

</div>

<!-- Edit Gallery Modal -->
<div id="edit-gallery-modal" style="display:none;">
    
    <form action="#" method="post" class="gallery-form">
        <h3 class="mb-4">Edit Gallery</h3>
        <input type="hidden" name="edit-gallery" />
        <?php echo $tpl->render( 'lg-text-input', array( "id" => "gallery-name-input", "name" => "gallery-name", "label" => "Gallery Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lg-checkbox-input', array( "id" => "publish-gallery-check", "name" => "publish-gallery", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'lg-form-buttons', array( "value" => "Save" )); ?>
    </form>

</div>

<!-- Delete Gallery Modal -->
<?php echo $tpl->render( 'lg-delete-modal', array( "id" => "delete-gallery-modal", "name" => "delete-gallery", "to_delete" => "gallery-name" )); ?>
