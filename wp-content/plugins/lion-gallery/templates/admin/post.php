<?php

/**
 * Handle Database Query Result
 * So that correct server response is sent
 */
function handleGalleryResult($result, $type, $name) {
    if($result !== false) {
        if($type == "add") {
            echo "<strong>Success!</strong> " . $name . " added successfully.";
        } else if($type == "edit") {
            echo "<strong>Success!</strong> " . $name . " updated successfully.";
        } else if($type == "delete") {
            echo "<strong>Success!</strong> " . $name . " deleted successfully.";
        } else if($type == "reorder") {
            echo "<strong>Success!</strong> Menu reordered successfully.";
        }
    } else {
        echo "<strong>Failure!</strong> Something went wrong. Please try again.";
    }
}

/**
 * WordPress AJAX Hook
 * Handle any POST/AJAX requests
 */
function handle_ajax_gallery() {
    // require DB class & init
    require_once( WP_PLUGIN_DIR . '/lion-gallery/includes/lg-sql-manager.class.php' );
    $db = new LGSQLManager();

    // retrieve & parse form data
    $form_data = array();
    parse_str($_POST["form_data"], $form_data);

    // handle request
    if($form_data) {
        // Add Gallery
        if(array_key_exists("add-gallery",$form_data)) {
            $params = array(
                'title' => $form_data["gallery-name"],
                'description' => $form_data["gallery-name"],
                'date_created' => current_time( 'mysql' ),
                'toPublish' => (array_key_exists("publish-gallery", $form_data))?(1):(0)
            );

            $result = $db->insert("galleries", $params);

            handleGalleryResult($result, "add", $form_data["gallery-name"]);
        }
        // Edit Gallery
        if(array_key_exists("edit-gallery",$form_data)) {
            $result = $db->update("gallery", array(
                    'name' => $form_data["gallery-name"],
                    'toPublish' => (array_key_exists("publish-gallery", $form_data))?(1):(0)
                ), 
                array('id' => $form_data["edit-gallery"])
            );

            handleGalleryResult($result, "edit", $form_data["gallery-name"]);
        }
        // Delete Gallery
        if(array_key_exists("delete-gallery",$form_data)) {
            $result = $db->delete("gallery", array(
                'id' => $form_data["delete-gallery"]
            ));

            handleGalleryResult($result, "delete", $form_data["gallery-name"]);
        }

    }

    wp_die();
}

// WordPress AJAX action
add_action( 'wp_ajax_handle_ajax', 'handle_ajax_gallery');
