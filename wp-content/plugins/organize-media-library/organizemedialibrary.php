<?php
/**
 * Plugin Name: Organize Media Library by Folders
 * Plugin URI:  https://wordpress.org/plugins/organize-media-library/
 * Description: Organize Media Library by Folders. URL in the content, replace with the new URL.
 * Version:     6.48
 * Author:      Katsushi Kawamori
 * Author URI:  https://riverforest-wp.info/
 * Text Domain: organize-media-library
 * Domain Path: /languages
 *
 * @package Organize Media Library by Folders
 */

/*
	Copyright (c) 2015- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

add_action( 'plugins_loaded', 'organize_media_library_load_textdomain' );
/** ==================================================
 * i18n
 *
 * @since 1.00
 */
function organize_media_library_load_textdomain() {
	load_plugin_textdomain( 'organize-media-library' );
}

if ( ! class_exists( 'OrganizeMediaLibraryRegist' ) ) {
	require_once( dirname( __FILE__ ) . '/lib/class-organizemedialibraryregist.php' );
}
if ( ! class_exists( 'OrganizeMediaLibraryAdmin' ) ) {
	require_once( dirname( __FILE__ ) . '/lib/class-organizemedialibraryadmin.php' );
}


