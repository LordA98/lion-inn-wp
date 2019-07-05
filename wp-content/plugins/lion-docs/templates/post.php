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
            'section' => $_POST["section"],
            'parent_doc' => $_POST["parent-doc"],
            'toPublish' => (isset($_POST["publish-event"]))?(1):(0)
        );

        $db->insert("docs", $params);

        upload_file();

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
            WP_PLUGIN_DIR . '/lion-docs/docs/pdf/' . $_POST["section"] . '/' . $_FILES['file-upload']['name']
        );

    }
}


// BELOW CODE WAS FAILED AJAX ATTEMPT - MAY BE USEFUL IF I TRY TO DO AJAX VERSION AGAIN

/**
 * Handle Database Query Result
 * So that correct server response is sent
 */
// function handleDocsResult($result, $type, $name) {
//     if($result !== false) {
//         if($type == "add") {
//             echo "<strong>Success!</strong> " . $name . " added successfully.";
//         } else if($type == "edit") {
//             echo "<strong>Success!</strong> " . $name . " updated successfully.";
//         } else if($type == "delete") {
//             echo "<strong>Success!</strong> " . $name . " deleted successfully.";
//         } else if($type == "reorder") {
//             echo "<strong>Success!</strong> Menu reordered successfully.";
//         }
//     } else {
//         echo "<strong>Failure!</strong> Something went wrong. Please try again.";
//     }
// }

// /**
//  * WordPress AJAX Hook
//  * Handle any POST/AJAX requests
//  */
// function handle_ajax_docs() {
//     // require DB class & init
//     require_once( WP_PLUGIN_DIR . '/lion-docs/includes/ld-sql-manager.class.php' );
//     $db = new LDSQLManager();

//     // retrieve & parse form data
//     $form_data = array();
//     parse_str($_POST["form_data"], $form_data);

//     // handle request
//     if($form_data) {
//         // Add Doc
//         if(array_key_exists("add-doc",$form_data)) {
//             $params = array(
//                 'title' => $form_data["doc-name"],
//                 'filename' => $form_data["file-upload"],
//                 'date_uploaded' => current_time( 'mysql' ),
//                 'section' => $form_data["section"],
//                 'parent_doc' => $form_data["parent-doc"],
//                 'toPublish' => (array_key_exists("publish-doc", $form_data))?(1):(0)
//             );

//             $result = $db->insert("docs", $params);

//             handleDocsResult($result, "add", $form_data["doc-name"]);
//         }
//     }

//     wp_die();
// }

// // WordPress AJAX action
// add_action( 'wp_ajax_handle_ajax_docs', 'handle_ajax_docs' );

