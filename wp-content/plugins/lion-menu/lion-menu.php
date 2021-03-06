<?php
/** 
 * @package LionMenu
 */
/**
 * Plugin Name: Lion Menu
 * Plugin URI:
 * Description: Menu Plugin for Restuarants & Pubs
 * Version: 1.0.0
 * Author: Alexander Lord
 * Author URI:
 */

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

require_once(plugin_dir_path(__FILE__).'/includes/lm-template.class.php');
require_once(plugin_dir_path(__FILE__).'/includes/lm-sql-manager.class.php');
require_once(plugin_dir_path(__FILE__).'templates/admin/post.php');

/**
 * Plugin Class
 */
class LionMenu {

    /**
     * LMSQLManager - Manage Database
     */
    public $db;

    /**
     * Class Constructor
     */
	public function __construct() {
        $this->db = new LMSQLManager();

        // Setup Admin Pages
        add_action('admin_menu', array( $this, 'admin_menu_pages' ) );
    }

    /**
     * Register Assets
     */
    public function register() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    /**
     * Plugin Activation Hook
     */
	function activate() {
        $this->db->createTables();

        flush_rewrite_rules();
	}

    /**
     * Plugin Deactivation Hook
     */
	function deactivate() {
        flush_rewrite_rules();
	}

    /**
     * Enqueue Assets
     */
    public function enqueue() {
        // Add Main CSS
        wp_enqueue_style('lm-style', plugins_url() . '/lion-menu/assets/css/style.css');

        // Add JQuery Sortable
        /**
         * **** VERY IMPORTANT ****
         * sortable.min.js blocks the functionality of jquery-sortable and essentially
         * breaks our menu.  So we have completely commented out that file to prevent it blocking.
         * IF the menu stops working - it's probably because any update has uncommented this out.
         */ 
        wp_enqueue_script('jquery-sortable', plugins_url() . '/lion-menu/assets/js/jquery-sortable.js', array('jquery'));

        // Add Custom Javascript
        wp_enqueue_script('lm-edit-menu', plugins_url() . '/lion-menu/assets/js/edit-menu.js', array('jquery'));
        wp_enqueue_script('lm-lists', plugins_url() . '/lion-menu/assets/js/custom-lists.js', array('jquery'));
        wp_enqueue_script('lm-ajax', plugins_url() . '/lion-menu/assets/js/ajax.js', array('jquery'));

        // Add getUrlParam plugin code
        //https://github.com/repalogic/jquery.geturlparam && https://mathias-bank.de/2007/04/21/jquery-plugin-geturlparam-version-2/
        wp_enqueue_script('get-url-param', plugins_url() . '/lion-menu/assets/js/getUrlParam.js', array('jquery'));

        // Add Bootstrap CSS & JS & PopperJS
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'));
        wp_enqueue_style('bs-css', plugins_url() . '/lion-menu/assets/css/bootstrap.min.css');
        wp_enqueue_script('bs-js', plugins_url() . '/lion-menu/assets/js/bootstrap.min.js');
        
        // Font Awesome
        wp_enqueue_style('fa-icons', 'https://use.fontawesome.com/releases/v5.6.3/css/all.css');
    }
    
    /**
     * Add 'Menu' Option to Admin Menu & Init the Page
     * Create Subpages
     */
    public function admin_menu_pages() {
        add_menu_page( 'Menu Page', 'Menu', 'manage_options', 'lm-menu-page', array( $this, 'menu_init' ), ' ' );
        add_submenu_page( 'lm-menu-page', 'Menu Edit Subpage', 'Edit Menu', 'manage_options', 'lm-menu-edit-subpage', array( $this, 'edit_menu_init' ) );
    }
    
    /**
     * Initialise Admin Page with Menu-related content
     */
    public function menu_init() {
        
        $tpl = new LMTemplate( __DIR__ . '/templates/admin' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'lm-modals' );

        // message response
        echo $tpl->render( 'lm-message' );

        // Print Header section of Admin Page
        $data = array ('title' => 'Menu', 'desc' => "Create and manage menu's from this page. Click 'Add Menu' below to create a new menu. Select a menu from the list below to edit a menu.");
        echo $tpl->render( 'lm-header', $data );
        
        // Display save button and it's functionality
        echo $tpl->render( 'lm-menu-buttons' );
        
        // Get Menu's
        $menus = $this->db->get( 'menu' );
        if(!$menus) {
            echo "You have not created any menu's.";
            return;
        }

        // Display menu's as sortable list
        echo $tpl->render( 'lm-list' , array( "listOf" => $menus, "type" => "MENUS", "classes" => "sortable vertical list-group ml-0" ));
    }

    /**
     * Subpage: Edit a Menu
     * Accessed when a menu is selected from the Admin Page or subpage is selected from menu
     */
    public function edit_menu_init() {

        $tpl = new LMTemplate( __DIR__ . '/templates/admin' );
        $icon_tpl = new LMTemplate( __DIR__ . '/templates/admin/items' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'lm-modals' );

        // message response
        echo $tpl->render( 'lm-message' );

        // Render Title and Desc
        $data = array ('title' => 'Edit Menu', 'desc' => "Edit Menu Here.  Use the 'Change Menu' dropdown below to select a new menu.");
        echo $tpl->render( 'lm-header', $data );

        // Render save and change menu buttons
        $menus = $this->db->get( 'menu' );
        echo $tpl->render( 'lm-top-level-buttons', array( "menus" => $menus) );

        // Print Sections & Items related to Menu
        if(isset($_GET["menu_id"]) && is_numeric($_GET["menu_id"])) {

            // Print Current Menu Title & Published Icon
            $current_menu = $this->db->get( 'menu', array ( "id" => $_GET["menu_id"] ) );
            $menu = $current_menu[0];            
            
            echo '<span class="menu-id" hidden>' . $_GET["menu_id"] . '</span>';
            echo '<span class="published" hidden>' . $menu->toPublish . '</span>';
            echo "<h1 class='menu-name'>$menu->name</h1>";

            if($menu->toPublish) {
                echo $icon_tpl->render( 'lm-icon', array( "classes" => "fas fa-check-circle toPublish mr-3", "tooltip" => "Published")); 
            } else {
                echo $icon_tpl->render( 'lm-icon', array( "classes" => "fas fa-times-circle mr-3", "tooltip" => "Not Published"));
            }

            echo $tpl->render( 'lm-second-level-buttons');
            
            $sections = $this->db->get( "section" , array ( "parent_menu" => $_GET["menu_id"] ) );

            echo "<div class='row'>";

            echo $tpl->render( 'lm-list' , array( "listOf" => $sections, "type" => "SECTIONS", "side" => 0, "isParentPublished" => $menu->toPublish, "classes" => "nested-sortable vertical ml-0 list-group col-6 pl-3 pr-4 sections-list" ));

            echo $tpl->render( 'lm-list' , array( "listOf" => $sections, "type" => "SECTIONS", "side" => 1, "isParentPublished" => $menu->toPublish, "classes" => "nested-sortable vertical ml-0 list-group col-6 pl-4 sections-list" ));
            
            echo "</div>";
        } else {
            echo "You have not selected a menu.  Please use the dropdown above.";
            return;
        }
        
    }

    /**
     * Render Menu(s)
     * Front-End
     */
    public function render_menu() {
        $tpl = new LMTemplate( __DIR__ . '/templates/front-end' );

        $menus = $this->db->get( "menu" , array ( "toPublish" => 1 ) );
                
        echo $tpl->render( 'list' , array( "listOf" => $menus, "type" => "MENUS", "classes" => " " ));
    }

    /**
     * Render Menu Nav
     * Front-End
     */
    public function render_menu_nav() {
        $tpl = new LMTemplate( __DIR__ . '/templates/front-end' );

        $nav = $this->db->get( "menu" , array ( "toPublish" => 1 ) );
                
        echo $tpl->render( 'list' , array( "listOf" => $nav, "type" => "NAV", "classes" => " " ));
    }

}

/**
 * Initialize the plugin
 */
if (class_exists( 'LionMenu' )) {
    $lionMenu = new LionMenu();
    $lionMenu->register();
}

/**
 * Hooks
 */
register_activation_hook(__FILE__, array( $lionMenu, 'activate' ) );
register_deactivation_hook(__FILE__, array( $lionMenu, 'deactivate' ) );