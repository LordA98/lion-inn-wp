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
        add_menu_page( 'Documentation Page', 'HowTo', 'manage_options', 'ld-how-to', array( $this, 'how_to_init' ), 'dashicons-media-document' );
        add_submenu_page( 'ld-how-to', 'Documentation & Groups', 'Documentation', 'manage_options', 'ld-docs-subpage', array( $this, 'docs_init' ) );
        add_submenu_page( 'ld-how-to', 'File Manager', 'File Manager', 'manage_options', 'ld-file-man-subpage', array( $this, 'file_man_init' ) );
    }
    
    /**
     * Initialise Admin Page with Menu-related content
     */
    public function how_to_init() {
        $tpl = new LDTemplate( __DIR__ . '/templates' );

        // Get default doc
        $default = $this->db->get( 'default' );

        // Render side nav & doc iframe
        echo $tpl->render( 'ld-how-to', array('groups' => $this->get_groups(), 'default' => $default[0]->filename ) );
    }

    /**
     * Upload New Documentation Subpage
     */
    public function docs_init() {
        $tpl = new LDTemplate( __DIR__ . '/templates' );
        $dcmt = new LDTemplate( __DIR__ . '/templates/documents' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'ld-modals' );

        // message response
        echo $tpl->render( 'lm-message' );

        // Print Header section of Admin Page
        $data = array ('title' => 'Upload Documentation', 'desc' => "Upload new documentation here to be visible on the 'HowTo' page.  NOTE: Only caters for 1 level of subgroups.");
        echo $tpl->render( 'ld-header', $data );

        // Upload button
        echo $dcmt->render( 'ld-doc-buttons' );

        // Default file for HowTo iFrame
        $default = $this->db->get( 'default' );
        if(!$default) $default = array(array("name" => "No Default Set", "title" => "No Default Set", "filename" => "No Default Set"));
        echo $dcmt->render( 'ld-default', $default[0] );

        // Display groups and docs on page
        echo $dcmt->render( 'ld-docs', array('groups' => $this->get_groups()) );
    }

    /**
     * Manage Documentation Files in File System that are used for docs
     */
    public function file_man_init() {
        $tpl = new LDTemplate( __DIR__ . '/templates' );
        $fls = new LDTemplate( __DIR__ . '/templates/files' );

        // Add Modal Support & Render Modals
        add_thickbox();
        echo $tpl->render( 'ld-modals' );

        // message response
        echo $tpl->render( 'lm-message' );

        // Print Header section of Admin Page
        $data = array ('title' => 'File Manager', 'desc' => "Manage files located in the file system.  These files are used for documentation.");
        echo $tpl->render( 'ld-header', $data );

        // Upload button
        echo $fls->render( 'ld-file-buttons' );

        // Display list of files in file system
        $files = $this->db->get( 'files' );
        echo $fls->render( 'ld-files', array('files' => $files) );
    }

    /**
     * Return array of groups, docs and files
     */
    private function get_groups() {
        // Get docs, groups & files
        $docs = $this->db->get( 'docs' );
        $groups = $this->db->get( 'groups' );
        $files = $this->db->get( 'files' );

        // Replace file FK with filenames
        array_walk($docs, function($doc) use (&$files) {
            array_walk($files, function($file) use (&$doc) {
                if($file->id == $doc->file) {
                    $doc->filename = $file->name;
                }
            });
        });
                
        // Assign docs to corresponding groups and subgroups
        array_walk($groups, function($group) use (&$docs) {
            $group->docs = [];
            array_walk($docs, function($doc) use (&$group) {
                if($group->id === $doc->doc_group) {
                    array_push($group->docs, $doc);
                }
            });
        });
        
        // Separate into groups and subgroups
        $subsub = array_filter($groups, function($group) { return ($group->level == 3); });
        $sub = array_filter($groups, function($group) { return ($group->level == 2); });
        $groups = array_filter($groups, function($group) { return ($group->level == 1); });

        // Merge subsubgroups into parent subgroups
        array_walk($sub, function($sub) use (&$subsub) {
            $sub->subgroups = [];
            array_walk($subsub, function($ss) use (&$sub) {
                if($sub->id === $ss->parent_group) {
                    array_push($sub->subgroups, $ss);
                }
            });
        });

        // Merge subgroups into parent groups
        array_walk($groups, function($group) use (&$sub) {
            $group->subgroups = [];
            array_walk($sub, function($s) use (&$group) {
                if($group->id === $s->parent_group) {
                    array_push($group->subgroups, $s);
                }
            });
        });

        return $groups;
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
