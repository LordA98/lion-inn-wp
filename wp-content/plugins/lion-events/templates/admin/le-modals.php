<?php $tpl = new LETemplate( __DIR__ . '/forms' ); ?>

<!-- Add Event Modal -->
<div id="add-event-modal" style="display:none;">

    <form action="#" method="post">
        <h3 class="mb-4">Add Event</h3>
        <input type="hidden" name="add-event" />
        <?php echo $tpl->render( 'le-text-input', array( "id" => "event-name-input", "name" => "event-name", "label" => "Event Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'le-text-input', array( "id" => "event-date-input", "name" => "event-date", "label" => "Event Date", "placeholder" => "Enter Date" )); ?>
        <?php echo $tpl->render( 'le-checkbox-input', array( "id" => "publish-event-check", "name" => "publish-event", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'le-textarea-input', array( "id" => "desc-input-sml", "name" => "event-desc-sml", "label" => "Small Description", "optClasses" => "hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'le-textarea-input', array( "id" => "desc-input-lrg", "name" => "event-desc-lrg", "label" => "Large Description", "optClasses" => "hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'le-form-buttons', array( "value" => "Add" )); ?>
    </form>

</div>

<!-- Edit Menu Modal -->
<div id="edit-event-modal" style="display:none;">
    
    <form action="#" method="post">
        <h3 class="mb-4">Edit Event</h3>
        <input type="hidden" name="edit-event" />
        <?php echo $tpl->render( 'le-text-input', array( "id" => "event-name-input", "name" => "event-name", "label" => "Event Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'le-text-input', array( "id" => "event-date-input", "name" => "event-date", "label" => "Event Date", "placeholder" => "Enter Date" )); ?>
        <?php echo $tpl->render( 'le-checkbox-input', array( "id" => "publish-event-check", "name" => "publish-event", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'le-textarea-input', array( "id" => "desc-input-sml", "name" => "event-desc-sml", "label" => "Small Description", "optClasses" => "hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'le-textarea-input', array( "id" => "desc-input-lrg", "name" => "event-desc-lrg", "label" => "Large Description", "optClasses" => "hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'le-form-buttons', array( "value" => "Edit" )); ?>
    </form>

</div>

<!-- Delete Menu Modal -->
<div id="delete-event-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-event" /> <br/>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>
