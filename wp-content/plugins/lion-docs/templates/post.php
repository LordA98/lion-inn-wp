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
            'file' => $_POST["filename"],
            'date_uploaded' => current_time( 'mysql' ),
            'doc_group' => $_POST["group"],
            'toPublish' => (isset($_POST["publish-doc"]))?(1):(0)
        );

        $db->insert("docs", $params);

        return;
    }

    // Edit Document
    if(isset($_POST["edit-doc"])) {
        $db->update("docs", array(
            'title' => $_POST["doc-name"],
            'file' => $_POST["filename"],
            'date_updated' => current_time( 'mysql' ),
            'doc_group' => $_POST["group"],
            'toPublish' => (isset($_POST["publish-doc"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-doc"])
        );

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
        if(!isset($_POST["is-sub-group"]) || $_POST["parent-group"] == "0") {
            $parent = NULL;
            $level = 1;
        } else {
            $arr = explode("-", $_POST["parent-group"]);
            $parent = $arr[0];
            $level = $arr[1] + 1;
        }

        $params = array(
            'name' => $_POST["group-name"],
            'level' => $level,
            'parent_group' => $parent,
            'toPublish' => (isset($_POST["publish-group"]))?(1):(0)
        );

        $db->insert("groups", $params);

        return;
    }

    // Edit Group
    if(isset($_POST["edit-group"])) {
        if(!isset($_POST["is-sub-group"]) || $_POST["parent-group"] == "0") {
            $parent = NULL;
            $level = 1;
        } else {
            $arr = explode("-", $_POST["parent-group"]);
            $parent = $arr[0];
            $level = $arr[1] + 1;
        }

        $db->update("groups", array(
            'name' => $_POST["group-name"],
            'level' => $level,
            'parent_group' => $parent,
            'toPublish' => (isset($_POST["publish-group"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-group"])
        );

        return;
    }

    // Delete Group
    if(isset($_POST["delete-group"])) {
        // Delete desired group
        $db->delete("groups", array(
            'id' => $_POST["delete-group"]
        ));

        return;
    }

    // Upload File
    if(isset($_POST["add-file"])) {
        $total = count($_FILES['file-upload']['name']);

        for( $i = 0; $i < $total; $i++ ) {
            $name = null;
            if(isset($_FILES["file-upload"]) && $_FILES["file-upload"]["name"][$i] != "") {
                $name = $_FILES["file-upload"]["name"][$i];
            }

            $params = array(
                'name' => $name,
                'date_uploaded' => current_time( 'mysql' )
            );

            $db->insert("files", $params);

            if($name) upload_file(
                $_FILES['file-upload']['error'][$i], 
                $_FILES['file-upload']['name'][$i], 
                $_FILES['file-upload']['tmp_name'][$i]
            );
        }

        return;
    }

    // Delete File
    if(isset($_POST["delete-file"])) {
        $file = $db->get("files", array("id" => $_POST["delete-file"]));

        $db->delete("files", array(
            'id' => $_POST["delete-file"]
        ));

        delete_file($file[0]->name);

        return;
    }

    // Set Default Document for HowTo iFrame
    if(isset($_POST["edit-default"])) {
        if($_POST["edit-default"] == "insert") {
            $db->insert("default", array(
                'default_doc' => $_POST["default-doc"]
                )
            );
        } else {
            $db->update("default", array(
                'default_doc' => $_POST["default-doc"]
                ), 
                array('id' => $_POST["edit-default"])
            );
        }

        return;
    }

}

/**
 * Handle file upload to desired document directory
 */
function upload_file($error, $name, $tmpName) {
    if ( 0 < $error ) {

        ld_log_me('File Upload Error - ' . print_r($name));
        ld_log_me('File Upload Error - ' . print_r($error));
        echo 'Error: ' . print_r($error) . '<br>';

    } else {

        ld_log_me('File Upload Successful - ' . $name);
        move_uploaded_file(
            $tmpName, 
            WP_PLUGIN_DIR . '/lion-docs/docs/' . $name
        );

    }
}

/**
 * Delete uploaded documentation file
 */
function delete_file(string $filename) {
    wp_delete_file(WP_PLUGIN_DIR . '/lion-docs/docs/' . $filename);
}

