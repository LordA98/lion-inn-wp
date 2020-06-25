<?php

require_once( WP_PLUGIN_DIR . '/lion-docs/includes/ld-debug.php' );
require_once( WP_PLUGIN_DIR . '/lion-docs/includes/ld-sql-manager.class.php' );

/**
 * Handle POST Requests on Plugin Admin Page
 */
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = new LDSQLManager();

    // Add Document
    if(isset($_POST["add-doc"])) {
        $name = null;
        if(isset($_FILES["file-upload"])) {
            $name = $_FILES["file-upload"]["name"];
        }

        $params = array(
            'title' => $_POST["doc-name"],
            'filename' => $name,
            'date_uploaded' => current_time( 'mysql' ),
            'doc_group' => $_POST["group"],
            'toPublish' => (isset($_POST["publish-doc"]))?(1):(0)
        );

        $db->insert("docs", $params);

        // Response

        return;
    }

    // Edit Document
    if(isset($_POST["edit-doc"])) {
        $name = null;
        if(isset($_FILES["file-upload"])) {
            $name = $_FILES["file-upload"]["name"];
        }

        $db->update("docs", array(
            'title' => $_POST["doc-name"],
            'filename' => $name,
            'date_updated' => current_time( 'mysql' ),
            'doc_group' => $_POST["group"],
            'toPublish' => (isset($_POST["publish-doc"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-doc"])
        );

        // Response

        return;
    }

    // Delete Document
    if(isset($_POST["delete-doc"])) {
        $db->delete("docs", array(
            'id' => $_POST["delete-doc"]
        ));

        // Response

        return;
    }

    // Add Group
    if(isset($_POST["add-group"])) {
        if(!isset($_POST["is-sub-group"]) || $_POST["parent-group"] == "0") {
            $parent = NULL;
        } else {
            $parent = $_POST["parent-group"];
        }

        $params = array(
            'name' => $_POST["group-name"],
            'isSubGroup' => (isset($_POST["is-sub-group"]))?(1):(0),
            'parent_group' => $parent,
            'toPublish' => (isset($_POST["publish-group"]))?(1):(0)
        );

        $db->insert("groups", $params);

        // Response

        return;
    }

    // Edit Group
    if(isset($_POST["edit-group"])) {        
        if(!isset($_POST["is-sub-group"]) || $_POST["parent-group"] == "0") {
            $parent = NULL;
        } else {
            $parent = $_POST["parent-group"];
        }

        $db->update("groups", array(
            'name' => $_POST["group-name"],
            'isSubGroup' => (isset($_POST["is-sub-group"]))?(1):(0),
            'parent_group' => $parent,
            'toPublish' => (isset($_POST["publish-group"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-group"])
        );

        // Response

        return;
    }

    // Delete Group
    if(isset($_POST["delete-group"])) {
        // Delete desired group
        $db->delete("groups", array(
            'id' => $_POST["delete-group"]
        ));

        // Response.

        return;
    }

    // Upload File
    if(isset($_POST["add-file"])) {
        $name = null;
        if(isset($_FILES["file-upload"])) {
            $name = $_FILES["file-upload"]["name"];
        }

        $params = array(
            'filename' => $name,
            'date_uploaded' => current_time( 'mysql' )
        );

        $db->insert("files", $params);

        if($name) upload_file();

        // Response

        return;
    }

    // Delete File
    if(isset($_POST["delete-file"])) {
        $file = $db->get("files", array("id" => $_POST["delete-file"]));

        $db->delete("files", array(
            'id' => $_POST["delete-file"]
        ));

        delete_file($file[0]->filename);

        // Response

        return;
    }

}

/**
 * Handle file upload to desired document directory
 */
function upload_file() {
    if ( 0 < $_FILES['file-upload']['error'] ) {

        ld_log_me('File Upload Error - ' . $_FILES["file-upload"]['name']);
        ld_log_me('File Upload Error - ' . $_FILES["file-upload"]['error']);
        echo 'Error: ' . $_FILES['file-upload']['error'] . '<br>';

    } else {

        ld_log_me('File Upload Successful - ' . $_FILES["file-upload"]['name']);
        move_uploaded_file(
            $_FILES['file-upload']['tmp_name'], 
            WP_PLUGIN_DIR . '/lion-docs/docs/pdf/' . $_FILES['file-upload']['name']
        );

    }
}

/**
 * Delete uploaded documentation file
 */
function delete_file(string $filename) {
    wp_delete_file(WP_PLUGIN_DIR . '/lion-docs/docs/pdf/' . $filename);
}

