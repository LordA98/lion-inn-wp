<?php 
    $tpl = new LDTemplate( __DIR__ . '/forms' );

    require_once(plugin_dir_path(__DIR__) . '/includes/ld-sql-manager.class.php');
    $db = new LDSQLManager();
    $groups = $db->get( "groups" );
    $files = $db->get( "files" );
    $docs = $db->get( "docs" );

    // Split groups into 3 possible levels
    $l3 = array_filter($groups, function($group) { return ($group->level == 3); });
    $l2 = array_filter($groups, function($group) { return ($group->level == 2); });
    $l1 = array_filter($groups, function($group) { return ($group->level == 1); });

    // Assign parent group names for level 2
    array_walk($l2, function($g) use (&$l1) {
        array_walk($l1, function($gg) use (&$g) {
            if($g->parent_group == $gg->id) {
                $g->name = $gg->name . " // " . $g->name;
            }
        });
    });
    
    // Assign parent group names for level 3
    array_walk($l3, function($g) use (&$l2) {
        array_walk($l2, function($gg) use (&$g) {
            if($g->parent_group == $gg->id) {
                $g->name = $gg->name . " // " . $g->name;
            }
        });
    });
?>

<!-- Upload New Doc Modal -->
<div id="create-doc-modal" style="display:none;">

    <form action="#" method="post" class="doc-form">
        <h3 class="mb-4">Create Document</h3>
        <input type="hidden" name="add-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "group-select-input", "name" => "group", "label" => "Group", "options" => $groups, "purpose" => "groups" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "file-select-input", "name" => "filename", "label" => "File", "options" => $files, "purpose" => "files" )); ?>        
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Create" )); ?>
    </form>

</div>

<!-- Edit Doc Modal -->
<div id="edit-doc-modal" style="display:none;">
    
    <form action="#" method="post" class="doc-edit-form">
        <h3 class="mb-4">Edit Document</h3>
        <input type="hidden" name="edit-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "edit-group-select-input", "name" => "group", "label" => "Group", "options" => $groups, "purpose" => "groups")); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "edit-file-select-input", "name" => "filename", "label" => "File", "options" => $files, "purpose" => "files")); ?>        
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "edit-publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Edit" )); ?>
    </form>

</div>

<!-- Delete Doc Modal -->
<div id="delete-doc-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-doc" /> 
        <input type="hidden" name="doc-filename" /> <br/>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>


<!-- Create Group Modal -->
<div id="create-group-modal" style="display:none;">

    <form action="#" method="post" class="group-form">
        <h3 class="mb-4">Create Documentation Group</h3>
        <input type="hidden" name="add-group" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "group-name-input", "name" => "group-name", "label" => "Group Name", "placeholder" => "Enter Group Name" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "create-is-sub-check", "name" => "is-sub-group", "label" => "Subgroup", "optClasses" => "mb-3" )); ?>
        <span id="create-parent-group" style="display:none;">
            <?php echo $tpl->render( 'ld-select-input', array( "id" => "create-parent-group-input", "name" => "parent-group", "label" => "Parent Group", "options" => $groups, "purpose" => "groups" )); ?>        
        </span>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "create-publish-group-check", "name" => "publish-group", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Create" )); ?>
    </form>

</div>


<!-- Edit Group Modal -->
<div id="edit-group-modal" style="display:none;">
    
    <form action="#" method="post">
        <h3 class="mb-4">Edit Documentation Group</h3>
        <input type="hidden" name="edit-group" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "group-name-input", "name" => "group-name", "label" => "Group Name", "placeholder" => "Enter Group Name" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "edit-is-sub-check", "name" => "is-sub-group", "label" => "Subgroup", "optClasses" => "mb-3" )); ?>
        <span id="edit-parent-group" style="display:none;">
            <?php echo $tpl->render( 'ld-select-input', array( "id" => "edit-parent-group-input", "name" => "parent-group", "label" => "Parent Group", "options" => $groups, "purpose" => "groups" )); ?>        
        </span>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "edit-publish-group-check", "name" => "publish-group", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Edit" )); ?>
    </form>

</div>

<!-- Delete Group Modal -->
<div id="delete-group-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-group" /> <br/>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>


<!-- Upload File Modal -->
<div id="upload-file-modal" style="display:none;">

    <form action="upload.php" method="post" class="file-form" enctype="multipart/form-data">
        <h3 class="mb-4">Upload File</h3>
        <input type="hidden" name="add-file" />
        <?php echo $tpl->render( 'ld-file-upload', array( "id" => "file-upload-input", "name" => "file-upload[]", "label" => "Select File" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Upload" )); ?>
    </form>

</div>

<!-- Delete File Modal -->
<div id="delete-file-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-file" /> <br/>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>


<!-- Edit Default Modal -->
<div id="edit-default-modal" style="display:none;">
    
    <form action="#" method="post">
        <h3 class="mb-4">Edit Default Document</h3>
        <input type="hidden" name="edit-default" />        
        <span id="edit-default-doc">
            <?php echo $tpl->render( 'ld-select-input', array( "id" => "edit-default-group-input", "name" => "default-doc", "label" => "Default Doc", "options" => $docs, "purpose" => "docs" )); ?>        
        </span>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Edit" )); ?>
    </form>

</div>