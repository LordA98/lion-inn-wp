<?php
$docs = new LDTemplate( __DIR__ );
$nav = new LDTemplate( __DIR__ . '/nav' );

// TODO: figure out dynamic default
$default = plugins_url() . '/lion-docs/docs/general/accessing-the-admin-panel.pdf';
?>

<div class='container-fluid'>
    <div class='row py-3'>
        <div class='col-3'>
            <h3>HowTo Articles</h3>
            
            <?php echo $nav->render('ld-nav', array('groups' => $groups)); ?>
        </div>
        <div class='col' id='main'>
            <?php echo $docs->render('ld-iframe', array('pdf' => $default)); ?>
        </div>
    </div>
</div>
