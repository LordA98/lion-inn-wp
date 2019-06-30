<?php 
    $tpl = new LDTemplate( __DIR__ . '/forms' );
?>

<!-- Upload New Doc Modal -->
<div id="upload-doc-modal" style="display:none;">

    <form action="#" method="post">
        <h3 class="mb-4">Upload Documentation</h3>
        <input type="hidden" name="add-doc" />
        <?php echo $tpl->render( 'ld-text-input', array( "id" => "doc-name-input", "name" => "doc-name", "label" => "Document Name", "placeholder" => "Enter Display Name" )); ?>
        <?php echo $tpl->render( 'ld-file-upload', array( "id" => "file-upload-input", "name" => "file-upload", "label" => "Select File" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "select-input", "label" => "Section" )); ?>
        <?php echo $tpl->render( 'ld-select-input', array( "id" => "select-input-input", "name" => "select-input", "label" => "Parent Document" )); ?>
        <?php echo $tpl->render( 'ld-checkbox-input', array( "id" => "publish-doc-check", "name" => "publish-doc", "label" => "Publish", "optClasses" => "mb-3" )); ?>
        <?php echo $tpl->render( 'ld-form-buttons', array( "value" => "Upload" )); ?>
    </form>

</div>
