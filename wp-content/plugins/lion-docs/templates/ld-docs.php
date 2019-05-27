<?php
$docs = new LDTemplate( __DIR__ );
$nav = new LDTemplate( __DIR__ . '/nav' );

$default = plugins_url() . '/lion-docs/docs/pdf/general/accessing-the-admin-panel.pdf';
?>

<div class='container-fluid'>
    <div class='row py-3'>
        <div class='col-2'>
            <h3>HowTo Articles</h3>
            
            <?php echo $nav->render('ld-nav'); ?>
        </div>
        <div class='col' id='main'>
            <?php echo $docs->render('ld-iframe', array('pdf' => $default)); ?>
        </div>
    </div>
</div>
