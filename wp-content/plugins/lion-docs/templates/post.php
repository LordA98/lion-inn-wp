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
        $params = array(
            'title' => $_POST["doc-name"],
            'filename' => $_FILES["file-upload"]['name'],
            'date_uploaded' => current_time( 'mysql' ),
            'doc_group' => $_POST["group"],
            'toPublish' => (isset($_POST["publish-doc"]))?(1):(0)
        );

        $db->insert("docs", $params);

        upload_file();

        return;
    }

    // Edit Document
    if(isset($_POST["edit-doc"])) {
        $db->update("docs", array(
            'title' => $_POST["doc-name"],
            'filename' => $_FILES["file-upload"]['name'],
            'date_updated' => current_time( 'mysql' ),
            'doc_group' => $_POST["group"],
            'toPublish' => (isset($_POST["publish-doc"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-doc"])
        );

        // check if file exists and upload? or does this get handled?
        // upload_file();

        return;
    }

    // Delete Document
    if(isset($_POST["delete-doc"])) {
        $db->delete("docs", array(
            'id' => $_POST["delete-doc"]
        ));

        if(isset($_POST["delete-file"]) && file_not_linked_with_another_document($_POST["doc-filename"])) {
            delete_file($_POST["doc-filename"]);
        }

        // Response should include a message on whether file was removed or not.

        return;
    }

    // Add Group
    if(isset($_POST["add-group"])) {
        $params = array(
            'name' => $_POST["group-name"],
            'isSubGroup' => (isset($_POST["is-sub-group"]))?(1):(0),
            'parent_group' => ($_POST["parent-group"] == "0")?(NULL):($_POST["parent-group"]),
            'toPublish' => (isset($_POST["publish-group"]))?(1):(0)
        );

        $db->insert("groups", $params);

        return;
    }

    // Delete Group
    if(isset($_POST["delete-group"])) {
        // Delete desired group
        // $db->foreign_key_checks(0);
        $db->delete("groups", array(
            'id' => $_POST["delete-group"]
        ));
        // $db->foreign_key_checks(1);

        // Delete files in group from FS
        if(isset($_POST["delete-files"])) {
            delete_files_in_group($_POST["delete-group"]);
        }

        // Handle sub groups

        // Response should include a message on whether files were removed or not.

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

/**
 * Delete uploaded documentation files for this group
 */
function delete_files_in_group(string $group) {
    $db = new LDSQLManager();
    $docs = $db->get("docs", array("doc_group" => $group));

    array_walk($docs, function($doc) {
        if(file_not_linked_with_another_document($doc->filename))
            delete_file($doc->filename);
    });
}

/**
 * Check if a file is linked with another piece of documentation
 * Called before deleting a file
 */
function file_not_linked_with_another_document(string $filename) {
    $db = new LDSQLManager();
    $docs = $db->get("docs", array("filename" => "$filename"));
    if(count($docs) > 0) return false;
    return true;
}
