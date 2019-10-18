<?php $nav = new LDTemplate( __DIR__ ); ?>

<div id="accordion">
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

            <span class="level-2">Admin Panel Overview</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/admin-panel-overview-intro.pdf', 'title' => 'Introduction')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/admin-panel-overview-going-to-different-pages.pdf', 'title' => 'Going to Different Pages')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/admin-panel-overview-view-actual-website.pdf', 'title' => 'View the Actual Website')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/admin-panel-overview-logout.pdf', 'title' => 'Logout')); ?>
            </div>

            <span class="level-2">Managing Users</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/managing-users-intro.pdf', 'title' => 'Introduction')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/managing-users-add-user.pdf', 'title' => 'Add New User')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/managing-users-delete-user.pdf', 'title' => 'Delete User')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/managing-users-user-roles.pdf', 'title' => "User 'Roles'" )); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/managing-users-editing-roles.pdf', 'title' => 'Editing Roles')); ?>
            </div>
            <span class="level-2">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/the-text-editor.pdf', 'title' => 'The Text Editor')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/password-change.pdf', 'title' => 'Password Change / Password Reset')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/general/upload-images.pdf', 'title' => 'Upload Images')); ?>
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

            <span class="level-2">Adding</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-menu.pdf', 'title' => 'Add Menu')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-section.pdf', 'title' => 'Add Section')); ?>
                <div class="ml-4 level-4">
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-section-to-the-right.pdf', 'title' => 'Add to the Right' )); ?>
                </div>
                Add Item
                <div class="ml-4 level-4">
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-item-food.pdf', 'title' => 'Food Item' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-item-subtitle.pdf', 'title' => 'Subtitle Item' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-item-note.pdf', 'title' => 'Note Item' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-item-how-they-look.pdf', 'title' => 'How These Look on the Website' )); ?>
                </div>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/add-subitem.pdf', 'title' => 'Add Subitem')); ?>
            </div>

            <span class="level-2">Editing</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/edit-menu.pdf', 'title' => 'Edit Menu')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/edit-section.pdf', 'title' => 'Edit Section')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/edit-item.pdf', 'title' => 'Edit Item')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/edit-subitem.pdf', 'title' => 'Edit Subitem')); ?>
            </div>

            <span class="level-2">Deleting</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/delete-menu.pdf', 'title' => 'Delete Menu')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/delete-section.pdf', 'title' => 'Delete Section')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/delete-item.pdf', 'title' => 'Delete Item')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/delete-subitem.pdf', 'title' => 'Delete Subitem')); ?>
            </div>

            <span class="level-2">Reordering</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-menus.pdf', 'title' => 'Reorder Menu\'s')); ?>
                Reordering Menu Content (Sections, Items & Subitems)
                <div class="ml-4 level-4">
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-content-basic-usage.pdf', 'title' => 'Basic Usage' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-content-up-and-down.pdf', 'title' => 'Moving Up & Down' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-content-sections.pdf', 'title' => 'Moving Sections' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-content-items.pdf', 'title' => 'Moving Items' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-content-subitems.pdf', 'title' => 'Moving Subitems' )); ?>
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/menu/reorder-content-moving-sides.pdf', 'title' => 'Moving Sides' )); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="event-docs">
        <div id="event-heading">
            <a class="btn btn-link p-0 level-1" data-toggle="collapse" data-target="#collapse-event" aria-expanded="true" aria-controls="collapse-event">
                Events
            </a>
        </div>

        <div id="collapse-event" class="collapse hide ml-4" aria-labelledby="event-heading" data-parent="#accordion">
            <span class="level-2">Regular Events</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/regular-events-overview.pdf', 'title' => 'Overview')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/regular-events-view-event-info.pdf', 'title' => 'View Event Information')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/regular-events-edit-event-info.pdf', 'title' => 'Edit Event Information')); ?>
                <div class="ml-4 level-4">
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/regular-events-change-icon.pdf', 'title' => 'Changing the Icon')); ?>
                </div>
            </div>

            <span class="level-2">Upcoming Events</span>
            <div class="ml-4 level-3">
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/upcoming-events-overview.pdf', 'title' => 'Introduction')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/upcoming-events-add-event.pdf', 'title' => 'Add New Event')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/upcoming-events-edit-event.pdf', 'title' => 'Edit Event')); ?>
                <div class="ml-4 level-4">
                    <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/upcoming-events-change-image.pdf', 'title' => 'Change the Image' )); ?>
                </div>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/upcoming-events-delete-event.pdf', 'title' => 'Delete Event')); ?>
                <?php echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/pdf/events/upcoming-events-published-not-published.pdf', 'title' => 'Published & Not Published')); ?>
            </div>
        </div>
    </div>
</div>