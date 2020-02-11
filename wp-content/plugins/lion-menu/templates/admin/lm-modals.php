<?php $tpl = new LMTemplate( __DIR__ . '/forms' ); ?>

<!-- Add Menu Modal -->
<div id="add-menu-modal" style="display:none;">

    <form action="#" method="post" class="menu-form">
        <h3 class="mb-4">Add Menu</h3>
        <input type="hidden" name="add-menu" /> 
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "menu-name-input", "name" => "menu-name", "label" => "Menu Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-menu-check", "name" => "publish-menu", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Add" )); ?>
    </form>

</div>

<!-- Edit Menu Modal -->
<div id="edit-menu-modal" style="display:none;">
    
    <form action="#" method="post" class="menu-form">
        <h3 class="mb-4">Edit Menu</h3>
        <input type="hidden" name="edit-menu" />
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "menu-name-input", "name" => "menu-name", "label" => "Menu Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-menu-check", "name" => "publish-menu", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Save" )); ?>
    </form>

</div>

<!-- Delete Menu Modal -->
<?php echo $tpl->render( 'lm-delete-modal', array( "id" => "delete-menu-modal", "name" => "delete-menu", "to_delete" => "menu-name" )); ?>

<!-- Add Section Modal -->
<div id="add-section-modal" style="display:none;">

    <form action="#" method="post" class="menu-form">
        <h3 class="mb-4">Add Section</h3>
        <input type="hidden" name="add-section" /> 
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "section-name-input", "name" => "section-name", "label" => "Section Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-radio-input', array( "id" => "section-left-radio", "name" => "section-side", "label" => "Left", "value" => 0 )); ?>
        <?php echo $tpl->render( 'lm-radio-input', array( "id" => "section-right-radio", "name" => "section-side", "label" => "Right", "value" => 1 )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-section-check", "name" => "publish-section", "label" => "Publish", "optClasses" => "ml-5 mb-3" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Add" )); ?>
    </form>

</div>

<!-- Edit Section Modal -->
<div id="edit-section-modal" style="display:none;">

    <form action="#" method="post" class="menu-form">
        <h3 class="mb-4">Edit Section</h3>
        <input type="hidden" name="edit-section" />
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "section-name-input", "name" => "section-name", "label" => "Section Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-radio-input', array( "id" => "section-left-radio", "name" => "section-side", "label" => "Left", "value" => 0 )); ?>
        <?php echo $tpl->render( 'lm-radio-input', array( "id" => "section-right-radio", "name" => "section-side", "label" => "Right", "value" => 1 )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-section-check", "name" => "publish-section", "label" => "Publish", "optClasses" => "ml-5 mb-3" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Save" )); ?>
    </form>

</div>

<!-- Delete Section Modal -->
<?php echo $tpl->render( 'lm-delete-modal', array( "id" => "delete-section-modal", "name" => "delete-section", "to_delete" => "section-name" )); ?>


<!-- Add Item Modal -->
<div id="add-item-modal" style="display:none;">

    <form action="#" method="post" class="menu-form p-3">
        <h3>Add Item</h3>
        <input type="hidden" name="add-item" /> <br/>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "item-name-input", "name" => "item-name", "label" => "Item Name", "optClasses" => "hideIfNote", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "add-subsec-check", "name" => "item-subsec", "label" => "Subsection Title", "optClasses" => "mb-3 hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "add-note-check", "name" => "item-note", "label" => "Note", "optClasses" => "ml-5 mb-3 hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-item-check", "name" => "publish-item", "label" => "Publish", "optClasses" => "ml-5 mb-3" )); ?>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "price-input", "name" => "item-price", "label" => "Price", "optClasses" => "hideIfSubsec hideIfNote", "placeholder" => "0.00" )); ?>
        <?php echo $tpl->render( 'lm-textarea-input', array( "id" => "desc-input", "name" => "item-desc", "label" => "Description", "optClasses" => "hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "veg-check", "name" => "item-veg", "label" => "Vegetarian", "optClasses" => "hideIfSubsec hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "gf-check", "name" => "item-gf", "label" => "Gluten Free", "optClasses" => "hideIfSubsec hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "vegan-check", "name" => "item-vegan", "label" => "Vegan", "optClasses" => "hideIfSubsec hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Add" )); ?>
    </form>

</div>

<!-- Edit Item Modal -->
<div id="edit-item-modal" style="display:none;">

    <form action="" method="post" class="menu-form p-3">
        <h3>Edit Item</h3>
        <input type="hidden" name="edit-item" /> <br/>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "item-name-input", "name" => "item-name", "label" => "Item Name", "optClasses" => "hideIfNote", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "edit-subsec-check", "name" => "item-subsec", "label" => "Subsection Title", "optClasses" => "mb-3 hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "edit-note-check", "name" => "item-note", "label" => "Note", "optClasses" => "ml-5 mb-3 hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-item-check", "name" => "publish-item", "label" => "Publish", "optClasses" => "ml-5 mb-3" )); ?>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "price-input", "name" => "item-price", "label" => "Price", "optClasses" => "hideIfSubsec hideIfNote", "placeholder" => "0.00" )); ?>
        <?php echo $tpl->render( 'lm-textarea-input', array( "id" => "desc-input", "name" => "item-desc", "label" => "Description", "optClasses" => "hideIfSubsec" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "veg-check", "name" => "item-veg", "label" => "Vegetarian", "optClasses" => "hideIfSubsec hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "gf-check", "name" => "item-gf", "label" => "Gluten Free", "optClasses" => "hideIfSubsec hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "vegan-check", "name" => "item-vegan", "label" => "Vegan", "optClasses" => "hideIfSubsec hideIfNote" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Save" )); ?>        
    </form>

</div>

<!-- Delete Item Modal -->
<?php echo $tpl->render( 'lm-delete-modal', array( "id" => "delete-item-modal", "name" => "delete-item", "to_delete" => "item-name" )); ?>

<!-- Add Subitem Modal -->
<div id="add-subitem-modal" style="display:none;">

    <form action="#" method="post" class="menu-form p-3">
        <h3>Add Subitem</h3>
        <input type="hidden" name="add-subitem" /> <br/>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "subitem-name-input", "name" => "subitem-name", "label" => "Subitem Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "price-input", "name" => "subitem-price", "label" => "Price", "optClasses" => "hideIfSubsec", "placeholder" => "0.00" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-subitem-check", "name" => "publish-subitem", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Add" )); ?>       
    </form>

</div>

<!-- Edit Subitem Modal -->
<div id="edit-subitem-modal" style="display:none;">

    <form action="#" method="post" class="menu-form p-3">
        <h3>Edit Subitem</h3>
        <input type="hidden" name="edit-subitem" /> <br/>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "subitem-name-input", "name" => "subitem-name", "label" => "Subitem Name", "placeholder" => "Enter Name" )); ?>
        <?php echo $tpl->render( 'lm-text-input', array( "id" => "price-input", "name" => "subitem-price", "label" => "Price", "optClasses" => "hideIfSubsec", "placeholder" => "0.00" )); ?>
        <?php echo $tpl->render( 'lm-checkbox-input', array( "id" => "publish-subitem-check", "name" => "publish-subitem", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'lm-form-buttons', array( "value" => "Save" )); ?>        
    </form>

</div>

<!-- Delete Subitem Modal -->
<?php echo $tpl->render( 'lm-delete-modal', array( "id" => "delete-subitem-modal", "name" => "delete-subitem", "to_delete" => "subitem-name" )); ?>
