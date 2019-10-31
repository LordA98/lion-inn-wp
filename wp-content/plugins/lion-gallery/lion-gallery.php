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
        wp_enqueue_script('lg-ajax', plugins_url() . '/lion-gallery/assets/js/ajax.js', array('jquery'));

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
        $data = array ('title' => 'Gallery', 'desc' => "Create and manage galleries from this page.  To create or delete a gallery, go to the 'Media' section and create or delete a folder.  Ensure it is 'Published' below, so that it appears on the site.");
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
        $this->addNewGalleries($folders);
        $this->removeOldGalleries($folders);
    }

    /**
     * Support function for syncGalleries
     * Add new galleries if there are new folders in the media section
     */
    private function addNewGalleries($folders) {
        $galleries = $this->db->get( 'galleries' );

        foreach($folders as $folder) {
            $params = array(
                'title' => $folder->name,
                'date_created' => current_time( 'mysql' ),
                'toPublish' => 1
            );

            // Check if a folder already exists in the galleries database
            $alreadyExists = false;
            foreach($galleries as $gallery) {
                if($gallery->title == $folder->name) {
                    $alreadyExists = true;
                    continue;
                }
            }            
            
            // insert new gallery from media folders if it's new
            if($alreadyExists == false)
                $result = $this->db->insert("galleries", $params);
        }
    }

    /**
     * Support function for syncGalleries
     * Remove old galleries if the corresponding folders have been deleted from the media section
     */
    private function removeOldGalleries($folders) {
        $galleries = $this->db->get( 'galleries' );

        foreach($galleries as $gallery) {
            // check which galleries still have folders in media
            $exists = false;
            foreach($folders as $folder) {
                // If we find a match, it exists
                if($folder->name == $gallery->title) {
                    $exists = true;
                    break;
                }
            }

            // if we didn't find a match, that means the folder has been deleted from the media tab
            // so we remove it's corresponding gallery row
            if($exists == false) {
                $result = $this->db->delete("galleries", array(
                    'title' => $gallery->title
                ));
            }
        }
    }

    /**
     * Generate list Front-End 
     */
    public function render_galleries() {
        $tpl = new LGTemplate( __DIR__ . '/templates/front-end' );

        $images = $this->db->get( "gallery_images" );

        if(!$images) {
            echo "There are no images.";
            return;
        }

        // Get individual folders
        $galleries = array_count_values(
            array_column($images, 'name')
        );

        // Set each folders value to empty array
        array_walk($galleries, function(&$value) { $value = []; });

        // Assign each image name to it's corresponding folder
        array_walk($images, function($img) use (&$galleries) {
            // get image extension
            $extension = explode("/", $img->post_mime_type);
            if($extension[1] == 'jpeg') $extension[1] = "jpg";
            array_push($galleries[$img->name], $img->post_title . "." . $extension[1]);
        });

        // Remove all images except 1 to be used as thumbnail
        $thumbnails = $galleries;
        array_walk($thumbnails, function(&$gallery) {
            $gallery = array_slice($gallery, -1);
        });

        // TODO: iterate galleries and print a thumbnail template for each with the desired look from docs
        echo $tpl->render( 'gallery' , array("thumbnails" => $thumbnails) );

        // TODO: possibly assign galleries to post var or form var or something so that the photoswipe JS can pick it up and put it into an array for gallery?
    }

    /**
     * Generate Photoswipe
     */
    public function render_ps() {
        $tpl = new LGTemplate( __DIR__ . '/templates/front-end' );

        echo $tpl->render( 'photoswipe' );
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
