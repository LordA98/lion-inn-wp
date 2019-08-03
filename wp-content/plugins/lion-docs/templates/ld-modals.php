<?php 
    $tpl = new LDTemplate( __DIR__ . '/forms' );

    require_once(plugin_dir_path(__DIR__) . '/includes/ld-sql-manager.class.php');
    $db = new LDSQLManager();
    $docs = $db->get( "docs" );
?>

<!-- Upload New Doc Modal -->
<div id="upload-doc-modal" style="display:none;">

    <form action="upload.php" method="post" class="doc-form" enctype="multipart/form-data">
        <h3 class="mb-4">Upload Documentation</h3>
        <input type="hidden" name="add-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "section", "label" => "Section", "options" => "sections")); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "parent-doc", "label" => "Parent Document", "options" => $docs)); ?>
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
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "section", "label" => "Section", "options" => "sections")); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "parent-doc", "label" => "Parent Document", "options" => $docs)); ?>
        <?php echo $tpl->render( 'ld-file-upload', array( "id" => "file-upload-input", "name" => "file-upload", "label" => "Select File" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Upload" )); ?>
    </form>

</div>

<!-- Delete Doc Modal -->
<div id="delete-doc-modal" style="display:none;">

    <form action="#" method="post" class="row d-flex p-3">
        <h3 class="mb-4">Are you sure you want to delete this?</h3>
        <input type="hidden" name="delete-doc" /> <br/>
        <input type="submit" value="Delete" class="btn btn-danger ml-auto" />
    </form>

</div>
