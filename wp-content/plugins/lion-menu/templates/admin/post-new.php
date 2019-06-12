<?php

/**
 * Support Function
 * Set Item Type when Item is edited or added
 */
function setItemType() {
    if(isset($_POST["item-subsec"])) {
        return 'subtitle';
    } else if(isset($_POST["item-note"])) {
        return 'note';
    } else {
        return 'item';
    }
}

function handle_ajax() {
    require_once( WP_PLUGIN_DIR . '/lion-menu/includes/lm-sql-manager.class.php' );
    $db = new LMSQLManager();

    $form_data = array();
    parse_str($_POST["form_data"], $form_data);

    if($form_data) {
        $type = setItemType();

        $db->update("item", array(
                'name' => $form_data["item-name"],
                'date_updated' => current_time( 'mysql' ), 
                'editor' => get_current_user_id(),
                'price' => $form_data["item-price"],
                'type' => $type,
                'description' => $form_data["item-desc"],
                'isVegetarian' => (array_key_exists("item-veg",$form_data))?(1):(0),
                'isGlutenFree' => (array_key_exists("item-gf",$form_data))?(1):(0),
                'toPublish' => (array_key_exists("publish-item",$form_data))?(1):(0)
            ), 
            array('id' => $form_data["edit-item"]));
    }
    
    echo $form_data['item-name'];

    wp_die();
}
add_action( 'wp_ajax_handle_ajax', 'handle_ajax');
