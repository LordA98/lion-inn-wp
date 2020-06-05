<?php

/**
 * Handle POST Requests on Plugin Admin Page
 */
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once( WP_PLUGIN_DIR . '/lion-docs/includes/ld-debug.php' );
    require_once( WP_PLUGIN_DIR . '/lion-docs/includes/ld-sql-manager.class.php' );
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
