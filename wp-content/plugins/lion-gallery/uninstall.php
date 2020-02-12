<?php
/**
 * Trigger this file on plugin uninstall
 * 
 * @package LionGallery
 */

if( !defined( 'WP_UNINSTALL_PLUGIN' )) {
    die;
}

// Clear Database Data
require_once(plugin_dir_path(__FILE__).'/includes/lg-sql-manager.class.php');

$db = new LGSQLManager();

$db->deleteTables();