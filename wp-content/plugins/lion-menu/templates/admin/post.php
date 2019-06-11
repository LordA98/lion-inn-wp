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

/**
 * Handle POST Requests on Plugin Admin Page
 */
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once( WP_PLUGIN_DIR . '/lion-menu/includes/lm-sql-manager.class.php' );
    
    $db = new LMSQLManager();

    // Add Menu
    if(isset($_POST["add-menu"])) {
        $params = array(
            'name' => $_POST["menu-name"], 
            'date_created' => current_time( 'mysql' ), 
            'author' => get_current_user_id(),
            'toPublish' => (isset($_POST["publish-menu"]))?(1):(0)
        );

        $db->insert("menu", $params);
        return;
    }
    // Edit Menu
    if(isset($_POST["edit-menu"])) {
        $db->update("menu", array(
                'name' => $_POST["menu-name"],
                'toPublish' => (isset($_POST["publish-menu"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-menu"])
        );
        return;
    }
    // Delete Menu
    if(isset($_POST["delete-menu"])) {
        $db->delete("menu", array(
            'id' => $_POST["delete-menu"]
        ));
        return;
    }

    // Add Section
    if(isset($_POST["add-section"])) {
        $params = array(
            'name' => $_POST["section-name"], 
            'date_created' => current_time( 'mysql' ), 
            'author' => get_current_user_id(),
            'side' => $_POST["section-side"],
            'toPublish' => (isset($_POST["publish-section"]))?(1):(0),
            'parent_menu' => $_GET["menu_id"]
        );

        $db->insert("section", $params);
        return;
    }
    // Edit Section
    if(isset($_POST["edit-section"])) {
        $db->update("section", array(
                'name' => $_POST["section-name"],
                'side' => $_POST["section-side"],
                'toPublish' => (isset($_POST["publish-section"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-section"])
        );
        return;
    }
    // Delete Section
    if(isset($_POST["delete-section"])) {
        $db->delete("section", array(
            'id' => $_POST["delete-section"]
        ));
        return;
    }

    // Add Item
    if(isset($_POST["add-item"])) {
        $type = setItemType();

        $params = array(
            'name' => $_POST["item-name"], 
            'date_created' => current_time( 'mysql' ), 
            'author' => get_current_user_id(),
            'price' => $_POST["item-price"],
            'type' => $type,
            'description' => $_POST["item-desc"],
            'isVegetarian' => (isset($_POST["item-veg"]))?(1):(0),
            'isGlutenFree' => (isset($_POST["item-gf"]))?(1):(0),
            'toPublish' => (isset($_POST["publish-item"]))?(1):(0),
            'parent_section' => $_POST["add-item"]
        );

        $db->insert("item", $params);
        return;
    }
    // Edit Item
    // if(isset($_POST["edit-item"])) {
    //     $type = setItemType();
        
    //     $db->update("item", array(
    //             'name' => $_POST["item-name"],
    //             'date_updated' => current_time( 'mysql' ), 
    //             'editor' => get_current_user_id(),
    //             'price' => $_POST["item-price"],
    //             'type' => $type,
    //             'description' => $_POST["item-desc"],
    //             'isVegetarian' => (isset($_POST["item-veg"]))?(1):(0),
    //             'isGlutenFree' => (isset($_POST["item-gf"]))?(1):(0),
    //             'toPublish' => (isset($_POST["publish-item"]))?(1):(0)
    //         ), 
    //         array('id' => $_POST["edit-item"])
    //     );
    //     return;
    // }
    // Delete Item
    if(isset($_POST["delete-item"])) {
        $db->delete("item", array(
            'id' => $_POST["delete-item"]
        ));
        return;
    }

    // Add Subitem
    if(isset($_POST["add-subitem"])) {
        $params = array(
            'name' => $_POST["subitem-name"], 
            'date_created' => current_time( 'mysql' ), 
            'author' => get_current_user_id(),
            'price' => $_POST["subitem-price"],
            'toPublish' => (isset($_POST["publish-subitem"]))?(1):(0),
            'parent_item' => $_POST["add-subitem"]
        );

        $db->insert("subitem", $params);
        return;
    }
    // Edit Subitem
    if(isset($_POST["edit-subitem"])) {
        $db->update("subitem", array(
                'name' => $_POST["subitem-name"],
                'date_updated' => current_time( 'mysql' ), 
                'editor' => get_current_user_id(),
                'price' => $_POST["subitem-price"],
                'toPublish' => (isset($_POST["publish-subitem"]))?(1):(0)
            ), 
            array('id' => $_POST["edit-subitem"])
        );
        return;
    }
    // Delete Subitem
    if(isset($_POST["delete-subitem"])) {
        $db->delete("subitem", array(
            'id' => $_POST["delete-subitem"]
        ));
        return;
    }

    // Save Menu List on main Menu admin page (Mainly to Save Rankings / Menu Order)
    if(isset($_POST["rankings"])) {
        // Remove '\' from JSON string & decode / convert to array
        $menu_rankings = str_replace("\\", "", $_POST["rankings"]);
        $menu_rankings = json_decode($menu_rankings, true);

        if(!$menu_rankings) return;
        
        // Update Menu List - set rank equal to it's turn ($i) in the $menu_rankings list
        $i = 1;
        // Menu Rankings array is formatted as Array ( [0] => Array ( [id] => 1 ) [1] => Array ( [id] => 7 )...
        // So a double loop is needed to access the menu id's.
        foreach($menu_rankings as $key => $value) {
            foreach($value as $id => $rank) {
                $db->update("menu", array(
                        'rank' => $i
                    ), 
                    array('id' => $rank)
                );
            }
            $i++;
        }

        return;
    }

    // Save Menu Item List on Edit Menu subpage (Mainly to Save Rankings / Order)
    if(isset($_POST["menu_item_rankings"])) {
        // Remove '\' from JSON string & decode / convert to array
        $item_rankings = str_replace("\\", "", $_POST["menu_item_rankings"]);
        $item_rankings = json_decode($item_rankings, true);

        if(!$item_rankings) return;
        
        // Update All Menu Item ranks 
        // Update section ranks --> update item ranks for section --> update subitem ranks for item
        $secRank = 1;
        $itemRank = 1;
        $subItemRank = 1;
        foreach($item_rankings as $key => $sections) {

            foreach($sections as $sKey => $sValue) {
                // Update Section Rank in sections table
                $db->update("section", array(
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
                    $db->update("item", array(
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
                        $db->update("subitem", array(
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

        return;
    }

}

?>