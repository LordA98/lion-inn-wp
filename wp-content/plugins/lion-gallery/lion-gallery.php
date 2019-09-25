<?php
/** 
 * @package LionGallery
 */
/**
 * Plugin Name: Lion Gallery
 * Plugin URI:
 * Description: Gallery Plugin - pulls folders from Media section.  Must be using a folder plugin (like FileBird & Mediamatic)
 * Version: 1.0.0
 * Author: Alexander Lord
 * Author URI:
 */

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

require_once(plugin_dir_path(__FILE__).'/includes/lg-template.class.php');
require_once(plugin_dir_path(__FILE__).'/includes/lg-sql-manager.class.php');
require_once(plugin_dir_path(__FILE__).'templates/admin/post.php');

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
        wp_enqueue_script('lg-ajax', plugins_url() . '/lion-gallery/assets/js/ajax.js', array('jquery'));

        // Add Bootstrap CSS & JS & PopperJS
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'));
        wp_enqueue_style('bs-css', plugins_url() . '/lion-gallery/assets/css/bootstrap.min.css');
        wp_enqueue_script('bs-js', plugins_url() . '/lion-gallery/assets/js/bootstrap.min.js');

        // Custom script that will interact with wp.media
        wp_enqueue_media();
        wp_enqueue_script( 'lg-media-manager', plugins_url( '/assets/js/media-manager.js' , __FILE__ ), array('jquery'), '0.1' );
    }
    
    /**
     * Add 'Menu' Option to Admin Menu & Init the Page
     * Create Subpages
     */
    public function admin_menu_pages() {
        add_menu_page( 'Gallery', 'Gallery', 'manage_options', 'lg-gallery', array( $this, 'gallery_init' ), 'dashicons-images-alt2' );
    }
    
    /**
     * Initialise Admin Page with Menu-related content
     */
    public function gallery_init() {
        $tpl = new LGTemplate( __DIR__ . '/templates/admin' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'lg-modals' );

        // ajax message response
        echo $tpl->render( 'lg-message' );

        // Print Header section of Admin Page
        $data = array ('title' => 'Gallery', 'desc' => "Create and manage galleries from this page.  To create a new gallery, go to the 'Media' section and create a new folder.  Ensure it is 'Published' below, so that it appears on the site.");
        echo $tpl->render( 'lg-header', $data );

        // Sync media folders to gallery database table
        $folders = $this->db->get( 'terms' );
        if(!$folders) {
            echo "ERROR :- Error retrieving folders from 'Media' tab.";
            return;
        }
        $this->syncGalleries($folders);

        // Get galleries and render them
        $galleries = $this->db->get( 'galleries' );
        if(!$galleries) {
            echo "ERROR :- There appears to have been an error syncing the 'Media' tab's folders with the galleries.";
            return;
        }
        echo $tpl->render( 'lg-galleries', array( 'galleries' => $galleries ));

    }

    /**
     * Support function to sync the Media folders into our plugins db table
     */
    private function syncGalleries($folders) {
        foreach($folders as $folder) {
            $params = array(
                'title' => $folder->name,
                'date_created' => current_time( 'mysql' ),
                'toPublish' => 1
            );

            // Check if a folder already exists in the galleries database
            $alreadyExists = false;
            $galleries = $this->db->get( 'galleries' );
            foreach($galleries as $gallery) {
                if($gallery->title == $folder->name) {
                    $alreadyExists = true;
                    continue;
                }
            }

            // remove galleries that no longer have a corresponding media folder
            // if gallery exists but doesn't have matching media folder, remove it
            
            // insert new gallery from media folders if it's new
            if($alreadyExists == false)
                $result = $this->db->insert("galleries", $params);
        }        
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
