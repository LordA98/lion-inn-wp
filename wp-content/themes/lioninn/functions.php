<?php

/**
 * Remove unneeded role types
 */
function remove_roles() {
    if( get_role('subscriber') ){
        remove_role( 'subscriber' );
    }
    if( get_role('author') ){
        remove_role( 'author' );
    }
    if( get_role('contributor') ){
        remove_role( 'contributor' );
    }
}
add_action( 'admin_menu', 'remove_roles' );

/**
 * Remove Posts and Comments from sidebar menu
 * Not needed for this site
 * 
 * NOTE :- Some pages are removed via the User Role Editor plugin
 */
function remove_menu_pages() {
    /**
     * Hide for everyone
     */
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );

    $user = wp_get_current_user();
    if(isset($user->roles[0])) { 
        $current_role = $user->roles[0];
    } else {
        $current_role = 'no_role';
    }

    /**
     * Hide for Owners
     */
    if($current_role == 'owner') {
        remove_menu_page( 'image-sizes' );
        remove_menu_page( 'versionpress' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'edit.php?post_type=udb_widgets' );
    }

    /**
     * Hide for Editors
     */
    if($current_role == 'editor') {
        remove_menu_page( 'image-sizes' );
        remove_menu_page( 'versionpress' );
        remove_menu_page( 'users.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'edit.php?post_type=udb_widgets' );
    }
}
add_action( 'admin_menu', 'remove_menu_pages' );

/**
 * Remove Sub Pages that aren't needed
 * 
 * NOTE :- Some subpages are removed via the User Role Editor plugin
 */
function remove_submenu_pages() {
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
    remove_submenu_page( 'tools.php', 'tools.php' );
    remove_submenu_page( 'tools.php', 'import.php' );
    remove_submenu_page( 'tools.php', 'export.php' );
    remove_submenu_page( 'tools.php', 'tools.php?page=export_personal_data' );
}
add_action( 'admin_menu', 'remove_submenu_pages', 110 );

/**
 * Print to debug.log file
 */
function log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}

/**
 * Print to console in browser dev tools
 */
function console_log($toPrint) {
    echo "<script>console.log('$toPrint');</script>";
}

/**
 * Queue JS
 */
function js_enqueue_scripts() {
    wp_enqueue_script ("my-ajax-handler", get_template_directory_uri() . "/gallery.js", array('jquery'));
    wp_localize_script('my-ajax-handler', 'the_ajax_script', array('ajaxurl' =>admin_url('admin-ajax.php')));
} 
add_action("wp_enqueue_scripts", "js_enqueue_scripts");

/**
 * AJAX Handler for Gallery
 */
function load_images_ajax() {
    if (class_exists( 'LionGallery' )) {

        $lionGallery = new LionGallery();
        if(method_exists($lionGallery, 'render_images')) {

            $lionGallery->render_images();
            wp_die();
    
        } else {
    
            echo "<h3>Error loading images for gallery in modal.</h3>";
            log_me("ERROR :- Error loading images for gallery in modal.");
            console_log("Error loading images for gallery in modal.");
            wp_die();
    
        }
    
    } else {
    
        echo "<h3>Sorry, there appears to be an error loading the images for this gallery.</h3>";
        log_me("ERROR :- LionGallery Class does not exist.  Object cannot be created.");
        console_log("Error :- Images can't loaded for gallery.");
        wp_die();
    
    }

	wp_die();
}
add_action('wp_ajax_nopriv_load_images_ajax', 'load_images_ajax');
add_action('wp_ajax_load_images_ajax', 'load_images_ajax');

/**
 * Ensure default page after logging in is the dashboard
 */
function admin_default_page() {
    return site_url() . '/wp-admin';
}  
add_filter('login_redirect', 'admin_default_page');

/**
 * Set image title to the image filename when an image is uploaded.
 */
add_action( 'add_attachment', 'modify_uploaded_file_title' );
function modify_uploaded_file_title( $attachment_ID ) 
{	
    $the_post = array();
    $the_post['ID'] = $attachment_ID;
	$filename = basename ( get_attached_file( $attachment_ID ) );
	$fileWithoutExtension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $the_post['post_title'] = $fileWithoutExtension;
    wp_update_post( $the_post );	
}

/**
 * Disable WordPress Update Notifications
 */


?>
