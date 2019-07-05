<?php
/** 
 * @package LionDocs
 */
/**
 * Plugin Name: Lion Docs
 * Plugin URI:
 * Description: Documentation Plugin Specifically for lioninn.co.uk site
 * Version: 1.0.0
 * Author: Alexander Lord
 * Author URI:
 */

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

require_once(plugin_dir_path(__FILE__).'/includes/ld-template.class.php');
require_once(plugin_dir_path(__FILE__).'/includes/ld-sql-manager.class.php');
require_once(plugin_dir_path(__FILE__).'templates/post.php');

/**
 * Plugin Class
 */
class LionDocs {

    /**
     * LDSQLManager - Manage Database
     */
    public $db;

    /**
     * Class Constructor
     */
	public function __construct() {
        $this->db = new LDSQLManager();

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
        wp_enqueue_style('ld-style', plugins_url() . '/lion-docs/assets/css/style.css');

        // Add Custom Javascript
        wp_enqueue_script('ld-edit-docs', plugins_url() . '/lion-docs/assets/js/edit-docs.js', array('jquery'));
        wp_enqueue_script('ld-ajax', plugins_url() . '/lion-docs/assets/js/ajax.js', array('jquery'));

        // Add Bootstrap CSS & JS & PopperJS
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'));
        wp_enqueue_style('bs-css', plugins_url() . '/lion-docs/assets/css/bootstrap.min.css');
        wp_enqueue_script('bs-js', plugins_url() . '/lion-docs/assets/js/bootstrap.min.js');
    }
    
    /**
     * Add 'Menu' Option to Admin Menu & Init the Page
     * Create Subpages
     */
    public function admin_menu_pages() {
        add_menu_page( 'Documentation Page', 'HowTo', 'manage_options', 'ld-how-to', array( $this, 'docs_init' ), 'dashicons-media-document' );
        add_submenu_page( 'ld-how-to', 'Upload Documentation', 'Upload', 'manage_options', 'ld-upload-docs-subpage', array( $this, 'upload_docs_init' ) );
    }
    
    /**
     * Initialise Admin Page with Menu-related content
     */
    public function docs_init() {
        $tpl = new LDTemplate( __DIR__ . '/templates' );

        // Render side nav & doc iframe
        echo $tpl->render( 'ld-docs' );
    }

    /**
     * Upload New Documentation Subpage
     */
    public function upload_docs_init() {
        $tpl = new LDTemplate( __DIR__ . '/templates' );
        $upld = new LDTemplate( __DIR__ . '/templates/upload' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'ld-modals' );

        // message response
        echo $tpl->render( 'lm-message' );

        // Print Header section of Admin Page
        $data = array ('title' => 'Upload Documentation', 'desc' => "Upload new documentation here to be visible on the 'HowTo' page.");
        echo $tpl->render( 'ld-header', $data );

        // Upload button
        echo $upld->render( 'ld-upload-button' );

        // List of docs
        $docs = $this->db->get( 'docs' );
        echo $tpl->render( 'ld-doc-list', array('docs' => $docs) );
    }
    
}

/**
 * Initialize the plugin
 */
if (class_exists( 'LionDocs' )) {
    $lionDocs = new LionDocs();
    $lionDocs->register();
}

/**
 * Hooks
 */
register_activation_hook(__FILE__, array( $lionDocs, 'activate' ) );
register_deactivation_hook(__FILE__, array( $lionDocs, 'deactivate' ) );
