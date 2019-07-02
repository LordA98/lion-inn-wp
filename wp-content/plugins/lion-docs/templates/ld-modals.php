<?php 
    $tpl = new LDTemplate( __DIR__ . '/forms' );

    require_once(plugin_dir_path(__DIR__) . '/includes/ld-sql-manager.class.php');
    $db = new LDSQLManager();
    $docs = $db->get( "docs" );
?>

<!-- Upload New Doc Modal -->
<div id="upload-doc-modal" style="display:none;">

    <form action="#" method="post" class="doc-form" enctype="multipart/form-data">
        <h3 class="mb-4">Upload Documentation</h3>
        <input type="hidden" name="add-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-file-upload', array( "id" => "file-upload-input", "name" => "file-upload", "label" => "Select File" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "section", "label" => "Section", "options" => "sections")); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "parent-doc", "label" => "Parent Document", "options" => $docs)); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Upload" )); ?>
    </form>

</div>
