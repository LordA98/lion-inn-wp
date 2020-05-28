<?php

/**
 * Handle Database Query Result
 * So that correct server response is sent
 */
function handleGalleryResult($result, $type, $name) {
    console_log($name);
    if($result !== false) {
        if($type == "edit") {
            echo "<strong>Success!</strong> " . $name . " updated successfully.";
        }
    } else {
        echo "<strong>Failure!</strong> Something went wrong. Please try again.";
    }
}

/**
 * WordPress AJAX Hook
 * Handle any POST/AJAX requests
 */
function handle_ajax_lg() {
    // require DB class & init
    require_once( WP_PLUGIN_DIR . '/lion-gallery/includes/lg-sql-manager.class.php' );
    $db = new LGSQLManager();

    // retrieve & parse form data
    $form_data = array();
    parse_str($_POST["form_data"], $form_data);

    // handle request
    if($form_data) {
        // Edit Gallery
        if(array_key_exists("edit-gallery",$form_data)) {
            $toggle = $form_data["publish-gallery"] ? 0 : 1;

            $result = $db->update("galleries", array(
                    'toPublish' => $toggle
                ), 
                array('id' => $form_data["edit-gallery"])
            );

            handleGalleryResult($result, "edit", $form_data["gallery-name"]);
        }
    }

    wp_die();
}
// WordPress AJAX action
add_action( 'wp_ajax_handle_ajax_lg', 'handle_ajax_lg');
