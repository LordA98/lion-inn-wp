<?php 
    $tpl = new LDTemplate( __DIR__ . '/forms' );

    require_once(plugin_dir_path(__DIR__) . '/includes/ld-sql-manager.class.php');
    $db = new LDSQLManager();
    $docs = $db->get( "groups" );
?>

<!-- Upload New Doc Modal -->
<div id="upload-doc-modal" style="display:none;">

    <form action="upload.php" method="post" class="doc-form" enctype="multipart/form-data">
        <h3 class="mb-4">Upload Documentation</h3>
        <input type="hidden" name="add-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "group-select-input", "name" => "group", "label" => "Group", "options" => $docs )); ?>
        <?php echo $tpl->render( 'ld-file-upload', array( "id" => "file-upload-input", "name" => "file-upload", "label" => "Select File" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Upload" )); ?>
    </form>

</div>

<!-- Edit Doc Modal -->
<div id="edit-doc-modal" style="display:none;">
    
    <form action="#" method="post">
        <h3 class="mb-4">Edit Documentation</h3>
        <input type="hidden" name="edit-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "group-select-input", "name" => "group", "label" => "Group", "options" => $docs)); ?>
        <?php echo $tpl->render( 'ld-file-upload', array( "id" => "file-upload-input", "name" => "file-upload", "label" => "Select File" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Edit" )); ?>
    </form>

</div>

<!-- Delete Doc Modal -->
<div id="delete-doc-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-doc" /> 
        <input type="hidden" name="doc-filename" /> <br/>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "delete-file", "name" => "delete-file", "label" => "Delete File from FS" )); ?>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>


<!-- Create Group Modal -->
<div id="create-group-modal" style="display:none;">

    <form action="#" method="post" class="doc-form">
        <h3 class="mb-4">Create Documentation Group</h3>
        <input type="hidden" name="add-group" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "group-name-input", "name" => "group-name", "label" => "Group Name", "placeholder" => "Enter Group Name" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "is-sub-check", "name" => "is-sub-group", "label" => "Subgroup", "optClasses" => "mb-3" )); ?>
        <span id="parent-group" style="display:none;">
            <?php echo $tpl->render( 'ld-select-input', array( "id" => "parent-group-input", "name" => "parent-group", "label" => "Parent Group", "options" => $docs )); ?>        
        </span>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-group", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Create" )); ?>
    </form>

</div>


<!-- Edit Group Modal -->
<div id="edit-group-modal" style="display:none;">
    
    <form action="#" method="post">
        <h3 class="mb-4">Edit Documentation Group</h3>
        <input type="hidden" name="edit-group" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "group-name-input", "name" => "group-name", "label" => "Group Name", "placeholder" => "Enter Group Name" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "is-sub-check", "name" => "is-sub-group", "label" => "Subgroup", "optClasses" => "mb-3" )); ?>
        <span id="parent-group" style="display:none;">
            <?php echo $tpl->render( 'ld-select-input', array( "id" => "parent-group-input", "name" => "parent-group", "label" => "Parent Group", "options" => $docs )); ?>        
        </span>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-group", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Edit" )); ?>
    </form>

</div>

<!-- Delete Group Modal -->
<div id="delete-group-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-group" /> <br/>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "delete-files", "name" => "delete-files", "label" => "Delete Files in Group" )); ?>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>