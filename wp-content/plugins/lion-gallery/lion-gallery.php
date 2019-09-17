<?php
/** 
 * @package LionGallery
 */
/**
 * Plugin Name: Lion Gallery
 * Plugin URI:
 * Description: Gallery Plugin for lioninn.co.uk
 * Version: 1.0.0
 * Author: Alexander Lord
 * Author URI:
 */

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

require_once(plugin_dir_path(__FILE__).'/includes/lg-template.class.php');
require_once(plugin_dir_path(__FILE__).'/includes/lg-sql-manager.class.php');
// require_once(plugin_dir_path(__FILE__).'templates/post.php');

/**
 * Plugin Class
 */
class LionGallery {

    /**
     * LGSQLManager - Manage Database
     */
    public $db;

    /**
     * Class Constructor
     */
	public function __construct() {
        $this->db = new LGSQLManager();

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
        $this->db->deleteTables();

        flush_rewrite_rules();
	}

    /**
     * Enqueue Assets
     */
    public function enqueue() {
        // Add Main CSS
        wp_enqueue_style('lg-style', plugins_url() . '/lion-gallery/assets/css/style.css');

        // Add Custom Javascript
        wp_enqueue_script('lg-edit-gallery', plugins_url() . '/lion-gallery/assets/js/edit-gallery.js', array('jquery'));

        // Add Bootstrap CSS & JS & PopperJS
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'));
        wp_enqueue_style('bs-css', plugins_url() . '/lion-gallery/assets/css/bootstrap.min.css');
        wp_enqueue_script('bs-js', plugins_url() . '/lion-gallery/assets/js/bootstrap.min.js');
    }
    
    /**
     * Add 'Menu' Option to Admin Menu & Init the Page
     * Create Subpages
     */
    public function admin_menu_pages() {
        add_menu_page( 'Gallery', 'Gallery', 'manage_options', 'lg-gallery', array( $this, 'gallery_init' ), 'dashicons-images-alt2' );
        add_submenu_page( 'lg-gallery', 'Manage A Gallery', 'Manage A Gallery', 'manage_options', 'lg-manage-single-gallery-subpage', array( $this, 'manage_gallery_init' ) );
    }
    
    /**
     * Initialise Admin Page with Menu-related content
     */
    public function gallery_init() {
        $tpl = new LGTemplate( __DIR__ . '/templates' );

        // Render side nav & doc iframe
        echo $tpl->render( 'lg-gallery' );
    }

    /**
     * Init Manage A Gallery subpage
     */
    public function manage_gallery_init() {
        $tpl = new LGTemplate( __DIR__ . '/templates' );

        // Render side nav & doc iframe
        echo $tpl->render( 'lg-manage' );
    }
    
}

/**
 * Initialize the plugin
 */
if (class_exists( 'LionGallery' )) {
    $lionGallery = new LionGallery();
    $lionGallery->register();
}

/**
 * Hooks
 */
register_activation_hook(__FILE__, array( $lionGallery, 'activate' ) );
register_deactivation_hook(__FILE__, array( $lionGallery, 'deactivate' ) );
