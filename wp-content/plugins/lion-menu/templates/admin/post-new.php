<?php

// Same handler function...
function my_action() {
    global $wpdb;
    $whatever = $_POST['edit-item'];
    $whataver = 'hello';
    echo $whatever;
    wp_die();
}
add_action( 'wp_ajax_my_action', 'my_action');

