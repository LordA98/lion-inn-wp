<?php $nav = new LDTemplate( __DIR__ ); ?>

<div id="accordion">

    <pre>
    <?php echo print_r($groups); ?>
    </pre>

    <?php 
        foreach($groups as $group) { 
            echo $nav->render('ld-group', $group);
        }            
    ?>
    

    <div id="general-docs">
        <div id="general-heading">
            <a class="btn btn-link p-0 level-1" data-toggle="collapse" data-target="#collapse-general" aria-expanded="true" aria-controls="collapse-general">
                General
            </a>
        </div>

        <div id="collapse-general" class="collapse show ml-4" aria-labelledby="general-heading" data-parent="#accordion">
            <span class="level-2">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/accessing-the-admin-panel.pdf', 'title' => 'Accessing the Admin Panel')); ?>
            </span>
        </div>
    </div>

    <div id="menu-docs">
        <div id="menu-heading">
            <a class="btn btn-link p-0 level-1" data-toggle="collapse" data-target="#collapse-menu" aria-expanded="true" aria-controls="collapse-menu">
                Menu
            </a>
        </div>

        <div id="collapse-menu" class="collapse hide ml-4" aria-labelledby="menu-heading" data-parent="#accordion">
            <span class="level-2">Overview</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/overview-access-menus.pdf', 'title' => 'Access the Menu\'s')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/overview-menu-section-item-subitem.pdf', 'title' => 'Menu, Section, Item, Subitem')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/overview-published-not-published.pdf', 'title' => 'Published & Not Published')); ?>
            </div>            
        </div>
    </div>
</div>
