<?php
/** 
 * @package LionEvents
 */
/**
 * Plugin Name: Lion Events
 * Plugin URI:
 * Description: Events Plugin for Restuarants & Pubs
 * Version: 1.0.0
 * Author: Alexander Lord
 * Author URI:
 */

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

require_once(plugin_dir_path(__FILE__).'/includes/le-template.class.php');
require_once(plugin_dir_path(__FILE__).'/includes/le-sql-manager.class.php');

/**
 * Plugin Class
 */
class LionEvents {

    /**
     * LESQLManager - Manage Database
     */
    public $db;

    /**
     * Class Constructor
     */
	public function __construct() {
        $this->db = new LESQLManager();

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
        wp_enqueue_style('le-style', plugins_url() . '/lion-events/assets/css/style.css');

        // Add Bootstrap CSS & JS & PopperJS
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'));
        wp_enqueue_style('bs-css', plugins_url() . '/lion-events/assets/css/bootstrap.min.css');
        wp_enqueue_script('bs-js', plugins_url() . '/lion-events/assets/js/bootstrap.min.js');

        // Add Custom Javascript
        wp_enqueue_script('le-edit-event', plugins_url() . '/lion-events/assets/js/edit-event.js', array('jquery'));
        wp_enqueue_script('le-r-edit-event', plugins_url() . '/lion-events/assets/js/edit-r-event.js', array('jquery'));
        
        // Font Awesome
        wp_enqueue_style('fa-icons', 'https://use.fontawesome.com/releases/v5.6.3/css/all.css');

        // Custom script that will interact with wp.media
        wp_enqueue_media();
        wp_enqueue_script( 'le-media-manager', plugins_url( '/assets/js/media-manager.js' , __FILE__ ), array('jquery'), '0.1' );
    
        // Summernote WYSIWYG Editor
        wp_enqueue_style('summernote-css', plugins_url() . '/lion-events/assets/css/summernote-lite.css');
        wp_enqueue_script('summernote-js', plugins_url() . '/lion-events/assets/js/summernote-lite.js', array('jquery'));
        // Custom script to enable editor
        wp_enqueue_script('enable-editor', plugins_url() . '/lion-events/assets/js/wysiwyg.js', array('jquery'));
    }
    
    /**
     * Add 'Menu' Option to Admin Menu & Init the Page
     * Create Subpages
     */
    public function admin_menu_pages() {
        add_menu_page( 'Events Page', 'Events', 'manage_options', 'le-events-page', array( $this, 'events_init' ), 'dashicons-calendar' );
        add_submenu_page( 'le-events-page', 'Regular Events Subpage', 'Regular Events', 'manage_options', 'le-r-events-edit-subpage', array( $this, 'regular_events_init' ) );
    }
    
    /**
     * Initialise Admin Page with Menu-related content
     */
    public function events_init() {
        
        $tpl = new LETemplate( __DIR__ . '/templates/admin' );

        // Render POST & GET request handlers
        echo $tpl->render( 'post' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'le-modals' );

        // Print Header section of Admin Page
        $data = array ('title' => 'Events', 'desc' => "Create and manage events from this page. Click 'Add Event' below to create a new menu. Select an event from the list below to edit it.");
        echo $tpl->render( 'le-header', $data );
        
        // Display add event button
        echo $tpl->render( 'le-event-buttons' );

        // Render list of events
        echo $tpl->render( 'le-upcoming-events' );
    }

    /**
     * Render Event(s)
     */
    public function render_events() {
        $tpl = new LETemplate( __DIR__ . '/templates/front-end' );

        $events = $this->db->get( "u_event" , array ( "toPublish" => 1 ) );      
                
        if(!$events) {
            echo "There are no upcoming events.";
            return;
        } else {
            foreach($events as $ev) {
                echo $tpl->render( 'event' , $ev );
            }
        }
    }

    /**
     * Regular Events Subpage
     */
    public function regular_events_init() {

        $tpl = new LETemplate( __DIR__ . '/templates/admin' );

        // Render POST & GET request handlers
        echo $tpl->render( 'post' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'le-modals' );

        // Print Header section of Admin Page
        $data = array ('title' => 'Regular Events', 'desc' => "Manage regular weekly events from this page.  Click a day to edit it.");
        echo $tpl->render( 'le-header', $data );

        // Render days
        echo $tpl->render( 'le-regular-events' );
    }

    /**
     * Render Regular Events Tabs in Front-End
     */
    public function render_r_events_nav() {
        $tpl = new LETemplate( __DIR__ . '/templates/front-end' );

        $r_events = $this->db->get( "r_event" );      
        
        if(!$r_events) {
            echo "There are no regular events at the moment.";
            return;
        } else {
            $i = 0;
            foreach($r_events as $ev) {
                $ev->isActive = $i++;
                echo $tpl->render( 'r_event_tab' , $ev );
            }
        }
    }

    /**
     * Render Regular Events section in Front-End
     */
    public function render_r_events() {
        $tpl = new LETemplate( __DIR__ . '/templates/front-end' );

        $r_events = $this->db->get( "r_event" );
                
        if(!$r_events) {
            echo "There are no regular events at the moment.";
            return;
        } else {
            $i = 0;
            foreach($r_events as $ev) {
                $ev->isActive = $i++;
                echo $tpl->render( 'r_event' , $ev );
            }
        }
    }
    
}

/**
 * Initialize the plugin
 */
if (class_exists( 'LionEvents' )) {
    $lionEvents = new LionEvents();
    $lionEvents->register();
}

/**
 * Hooks
 */
register_activation_hook(__FILE__, array( $lionEvents, 'activate' ) );
register_deactivation_hook(__FILE__, array( $lionEvents, 'deactivate' ) );
