<?php

/**
 * Support Function
 * Set Item Type when Item is edited or added
 */
function setItemType($form_data) {
    if(array_key_exists("item-subsec",$form_data)) {
        return 'subtitle';
    } else if(array_key_exists("item-note",$form_data)) {
        return 'note';
    } else {
        return 'item';
    }
}

/**
 * Handle Database Query Result
 * So that correct server response is sent
 */
function handleResult($result, $type, $name) {
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
function handle_ajax() {
    // require DB class & init
    require_once( WP_PLUGIN_DIR . '/lion-menu/includes/lm-sql-manager.class.php' );
    $db = new LMSQLManager();

    // retrieve & parse form data
    $form_data = array();
    parse_str($_POST["form_data"], $form_data);

    // handle request
    if($form_data) {
        // Add Menu
        if(array_key_exists("add-menu",$form_data)) {
            $params = array(
                'name' => $form_data["menu-name"], 
                'date_created' => current_time( 'mysql' ), 
                'author' => get_current_user_id(),
                'toPublish' => (array_key_exists("publish-menu", $form_data))?(1):(0)
            );

            $result = $db->insert("menu", $params);

            handleResult($result, "add", $form_data["menu-name"]);
        }
        // Edit Menu
        if(array_key_exists("edit-menu",$form_data)) {
            $result = $db->update("menu", array(
                    'name' => $form_data["menu-name"],
                    'toPublish' => (array_key_exists("publish-menu", $form_data))?(1):(0)
                ), 
                array('id' => $form_data["edit-menu"])
            );

            handleResult($result, "edit", $form_data["menu-name"]);
        }
        // Delete Menu
        if(array_key_exists("delete-menu",$form_data)) {
            $result = $db->delete("menu", array(
                'id' => $form_data["delete-menu"]
            ));

            handleResult($result, "delete", $form_data["menu-name"]);
        }

        // Add Section
        if(array_key_exists("add-section",$form_data)) {
            $params = array(
                'name' => $form_data["section-name"], 
                'date_created' => current_time( 'mysql' ), 
                'author' => get_current_user_id(),
                'side' => $form_data["section-side"],
                'toPublish' => (array_key_exists("publish-section", $form_data))?(1):(0),
                'parent_menu' => $form_data["add-section"] // contains parent menu_id (despite it's name)
            );

            $result = $db->insert("section", $params);

            handleResult($result, "add", $form_data["section-name"]);
        }
        // Edit Section
        if(array_key_exists("edit-section",$form_data)) {
            $result = $db->update("section", array(
                    'name' => $form_data["section-name"],
                    'side' => $form_data["section-side"],
                    'toPublish' => (array_key_exists("publish-section", $form_data))?(1):(0)
                ), 
                array('id' => $form_data["edit-section"])
            );

            handleResult($result, "edit", $form_data["section-name"]);
        }
        // Delete Section
        if(array_key_exists("delete-section",$form_data)) {
            $result = $db->delete("section", array(
                'id' => $form_data["delete-section"]
            ));

            handleResult($result, "delete", $form_data["section-name"]);
        }

        // Add Item
        if(array_key_exists("add-item",$form_data)) {
            $type = setItemType($form_data);

            $params = array(
                'name' => $form_data["item-name"], 
                'date_created' => current_time( 'mysql' ), 
                'author' => get_current_user_id(),
                'price' => $form_data["item-price"],
                'type' => $type,
                'description' => $form_data["item-desc"],
                'isVegetarian' => (array_key_exists("item-veg",$form_data))?(1):(0),
                'isGlutenFree' => (array_key_exists("item-gf",$form_data))?(1):(0),
                'isVegan' => (array_key_exists("item-vegan",$form_data))?(1):(0),
                'toPublish' => (array_key_exists("publish-item",$form_data))?(1):(0),
                'parent_section' => $form_data["add-item"]
            );

            $result = $db->insert("item", $params);

            handleResult($result, "add", $form_data["item-name"]);
        }
        // Edit Item
        if(array_key_exists("edit-item",$form_data)) {
            $type = setItemType($form_data);

            $result = $db->update("item", array(
                    'name' => $form_data["item-name"],
                    'date_updated' => current_time( 'mysql' ), 
                    'editor' => get_current_user_id(),
                    'price' => $form_data["item-price"],
                    'type' => $type,
                    'description' => $form_data["item-desc"],
                    'isVegetarian' => (array_key_exists("item-veg",$form_data))?(1):(0),
                    'isGlutenFree' => (array_key_exists("item-gf",$form_data))?(1):(0),
                    'isVegan' => (array_key_exists("item-vegan",$form_data))?(1):(0),
                    'toPublish' => (array_key_exists("publish-item",$form_data))?(1):(0)
                ), 
                array('id' => $form_data["edit-item"])
            );

            handleResult($result, "edit", $form_data["item-name"]);
        }
        // Delete Item
        if(array_key_exists("delete-item",$form_data)) {
            $result = $db->delete("item", array(
                'id' => $form_data["delete-item"]
            ));

            handleResult($result, "delete", $form_data["item-name"]);
        }

        // Add Subitem
        if(array_key_exists("add-subitem",$form_data)) {
            $params = array(
                'name' => $form_data["subitem-name"], 
                'date_created' => current_time( 'mysql' ), 
                'author' => get_current_user_id(),
                'price' => $form_data["subitem-price"],
                'toPublish' => (array_key_exists("publish-subitem", $form_data))?(1):(0),
                'parent_item' => $form_data["add-subitem"]
            );

            $result = $db->insert("subitem", $params);

            handleResult($result, "add", $form_data["subitem-name"]);
        }
        // Edit Subitem
        if(array_key_exists("edit-subitem",$form_data)) {
            $result = $db->update("subitem", array(
                    'name' => $form_data["subitem-name"],
                    'date_updated' => current_time( 'mysql' ), 
                    'editor' => get_current_user_id(),
                    'price' => $form_data["subitem-price"],
                    'toPublish' => (array_key_exists("publish-subitem", $form_data))?(1):(0)
                ), 
                array('id' => $form_data["edit-subitem"])
            );

            handleResult($result, "edit", $form_data["subitem-name"]);
        }
        // Delete Subitem
        if(array_key_exists("delete-subitem",$form_data)) {
            $result = $db->delete("subitem", array(
                'id' => $form_data["delete-subitem"]
            ));

            handleResult($result, "delete", $form_data["subitem-name"]);
        }

        // Save Menu List on main Menu admin page (Mainly to Save Rankings / Menu Order)
        if(array_key_exists("rankings",$form_data)) {
            // Remove '\' from JSON string & decode / convert to array
            $menu_rankings = str_replace("\\", "", $form_data["rankings"]);
            $menu_rankings = json_decode($menu_rankings, true);
            $result = 0;

            if(!$menu_rankings) wp_die();
            
            // Update Menu List - set rank equal to it's turn ($i) in the $menu_rankings list
            $i = 1;
            // Menu Rankings array is formatted as Array ( [0] => Array ( [id] => 1 ) [1] => Array ( [id] => 7 )...
            // So a double loop is needed to access the menu id's.
            foreach($menu_rankings as $key => $value) {
                foreach($value as $id => $rank) {
                    $result += $db->update("menu", array(
                            'rank' => $i
                        ), 
                        array('id' => $rank)
                    );
                }
                $i++;
            }

            if($result == 0) $result = false;
            handleResult($result, "reorder", "");
        }

        // Save Menu Item List on Edit Menu subpage (Mainly to Save Rankings / Order)
        if(array_key_exists("menu_item_rankings",$form_data)) {
            // Remove '\' from JSON string & decode / convert to array
            $item_rankings = str_replace("\\", "", $form_data["menu_item_rankings"]);
            $item_rankings = json_decode($item_rankings, true);

            if(!$item_rankings) wp_die();
            
            // Update All Menu Item ranks 
            // Update section ranks --> update item ranks for section --> update subitem ranks for item
            $result = 0;
            $secRank = 1;
            $itemRank = 1;
            $subItemRank = 1;
            foreach($item_rankings as $key => $sections) {

                foreach($sections as $sKey => $sValue) {
                    // Update Section Rank in sections table
                    $result += $db->update("section", array(
                            'rank' => $secRank,
                            'side' => $sValue['side']
                        ), 
                        array('id' => $sValue['id'])
                    );

                    // Update Rankings of Child Items
                    $items = $sValue['children'];
                    $items = reset($items);
                    foreach($items as $iKey => $iValue) {
                        // Update Each Item Rank & Parent Section in items table
                        $result += $db->update("item", array(
                                'rank' => $itemRank,
                                'parent_section' => $sValue['id']
                            ), 
                            array('id' => $iValue['id'])
                        );

                        // Update Rankings of Child Items
                        $subitems = $iValue['children'];
                        $subitems = reset($subitems);
                        foreach($subitems as $siKey => $siValue) {
                            // Update Each Item Rank & Parent Section in items table
                            $result += $db->update("subitem", array(
                                    'rank' => $subItemRank,
                                    'parent_item' => $iValue['id']
                                ), 
                                array('id' => $siValue['id'])
                            );

                            $subItemRank++;
                        }

                        $subItemRank = 1;
                        $itemRank++;
                    }

                    $itemRank = 1;
                    $secRank++;
                }

                $secRank = 1;            
            }

            if($result == 0) $result = false;
            handleResult($result, "reorder", "");
        }
    }

    wp_die();
}

// WordPress AJAX action
add_action( 'wp_ajax_handle_ajax', 'handle_ajax');
