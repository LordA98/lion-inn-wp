<?php
/**
 * Organize Media Library by Folders
 *
 * @package    Organize Media Library
 * @subpackage OrganizeMediaLibraryAdmin Main & Management screen
/*
	Copyright (c) 2013- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

$organizemedialibraryadmin = new OrganizeMediaLibraryAdmin();
add_action( 'admin_notices', array( $organizemedialibraryadmin, 'notices' ) );

/** ==================================================
 * Management screen
 */
class OrganizeMediaLibraryAdmin {

	/** ==================================================
	 * Path
	 *
	 * @var $plugin_base_dir  plugin_base_dir.
	 */
	private $plugin_base_dir;

	/** ==================================================
	 * Path
	 *
	 * @var $plugin_base_url  plugin_base_url.
	 */
	private $plugin_base_url;

	/** ==================================================
	 * Path
	 *
	 * @var $upload_dir  upload_dir.
	 */
	private $upload_dir;

	/** ==================================================
	 * Path
	 *
	 * @var $upload_path  upload_path.
	 */
	private $upload_path;

	/** ==================================================
	 * Add on bool
	 *
	 * @var $is_add_on_activate  is_add_on_activate.
	 */
	private $is_add_on_activate;

	/** ==================================================
	 * Construct
	 *
	 * @since 6.20
	 */
	public function __construct() {

		$this->plugin_base_dir = untrailingslashit( plugin_dir_path( __DIR__ ) );
		$this->plugin_base_url = untrailingslashit( plugin_dir_url( __DIR__ ) );

		if ( ! class_exists( 'OrganizeMediaLibrary' ) ) {
			include_once dirname( __FILE__ ) . '/class-organizemedialibrary.php';
		}

		$organizemedialibrary = new OrganizeMediaLibrary();
		list($this->upload_dir, $upload_url, $this->upload_path) = $organizemedialibrary->upload_dir_url_path();

		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'add_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ) );
		add_filter( 'manage_media_columns', array( $this, 'muc_column' ) );
		add_action( 'manage_media_custom_column', array( $this, 'muc_value' ), 12, 2 );
		add_action( 'restrict_manage_posts', array( $this, 'add_folder_filter' ), 13 );
		add_action( 'admin_footer', array( $this, 'custom_bulk_admin_footer' ) );
		add_action( 'load-upload.php', array( $this, 'custom_bulk_action' ) );
		add_action( 'admin_notices', array( $this, 'custom_bulk_admin_notices' ) );
		add_action( 'wp_enqueue_media', array( $this, 'insert_media_custom_filter' ) );

	}

	/** ==================================================
	 * Add a "Settings" link to the plugins page
	 *
	 * @param  array  $links  links array.
	 * @param  string $file   file.
	 * @return array  $links  links array.
	 * @since 1.00
	 */
	public function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty( $this_plugin ) ) {
			$this_plugin = 'organize-media-library/organizemedialibrary.php';
		}
		if ( $file == $this_plugin ) {
			$links[] = '<a href="' . admin_url( 'upload.php?page=organizemedialibrary-settings' ) . '">' . __( 'Settings' ) . '</a>';
		}
			return $links;
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.0
	 */
	public function add_pages() {
		add_media_page(
			__( 'Make folder', 'organize-media-library' ) . '&' . __( 'Settings' ),
			__( 'Make folder', 'organize-media-library' ) . '&' . __( 'Settings' ),
			'upload_files',
			'organizemedialibrary-settings',
			array( $this, 'settings_page' )
		);

	}

	/** ==================================================
	 * Add Css and Script
	 *
	 * @since 2.23
	 */
	public function load_custom_wp_admin_style() {
		if ( $this->is_my_plugin_screen() ) {
			wp_enqueue_style( 'jquery-responsiveTabs', $this->plugin_base_url . '/css/responsive-tabs.css', array(), '1.4.0' );
			wp_enqueue_style( 'jquery-responsiveTabs-style', $this->plugin_base_url . '/css/style.css', array(), '1.4.0' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-responsiveTabs', $this->plugin_base_url . '/js/jquery.responsiveTabs.min.js', array(), '1.4.0', false );
			wp_enqueue_script( 'organizemedialibrary-js', $this->plugin_base_url . '/js/jquery.organizemedialibrary.js', array( 'jquery' ), '1.00', false );
		}
	}

	/** ==================================================
	 * For only admin style
	 *
	 * @since 4.3
	 */
	private function is_my_plugin_screen() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'media_page_organizemedialibrary-settings' == $screen->id ) {
			return true;
		} else if ( is_object( $screen ) && 'upload' == $screen->id ) {
			return true;
		} else {
			return false;
		}
	}

	/** ==================================================
	 * Sub Menu
	 */
	public function settings_page() {

		if ( ! current_user_can( 'upload_files' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
		}

		$this->options_updated();

		$organizemedialibrary_settings = get_option( $this->wp_options_name() );
		$scriptname = admin_url( 'upload.php?page=organizemedialibrary-settings' );

		$plugin_datas = get_file_data( $this->plugin_base_dir . '/organizemedialibrary.php', array( 'version' => 'Version' ) );
		$plugin_version = __( 'Version:' ) . ' ' . $plugin_datas['version'];

		?>
			<div class="wrap">

			<h2>Organize Media Library by Folders</h2>

			<div id="organizemedialibrary-admin-tabs">
				  <ul>
					<li><a href="#organizemedialibrary-admin-tabs-1"><?php esc_html_e( 'Make folder', 'organize-media-library' ); ?>&<?php esc_html_e( 'Settings' ); ?></a></li>
					<li><a href="#organizemedialibrary-admin-tabs-2"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></a></li>
				</ul>
				<div id="organizemedialibrary-admin-tabs-1">
					<h2><?php esc_html_e( 'Make folder', 'organize-media-library' ); ?>&<?php esc_html_e( 'Settings' ); ?></h2>
					<form method="post" action="<?php echo esc_url( $scriptname ); ?>">
					<?php wp_nonce_field( 'oml_settings', 'organizemedialibrary_tabs' ); ?>

					<?php
					if ( function_exists( 'mb_check_encoding' ) ) {
						?>
						<div style="width: 100%; height: 100%; float: left; margin: 5px; padding: 5px; border: #CCC 2px solid;">
							<h3><?php esc_html_e( 'Character Encodings for Server', 'organize-media-library' ); ?></h3>
							<p><?php esc_html_e( 'It may receive an error if you are using a multi-byte name to the file or directory name. In that case, please change.', 'organize-media-library' ); ?></p>
							<select name="organizemedialibrary_character_code" style="width: 210px">
						<?php
						foreach ( mb_list_encodings() as $chrcode ) {
							if ( 'pass' <> $chrcode && 'auto' <> $chrcode ) {
								if ( $chrcode === $organizemedialibrary_settings['character_code'] ) {
									?>
										<option value="<?php echo esc_attr( $chrcode ); ?>" selected><?php echo esc_html( $chrcode ); ?></option>
										<?php
								} else {
									?>
										<option value="<?php echo esc_attr( $chrcode ); ?>"><?php echo esc_html( $chrcode ); ?></option>
										<?php
								}
							}
						}
						?>
							</select>
							<div style="clear: both;"></div>
						</div>
						<?php
					}
					?>
						<div style="width: 100%; height: 100%; float: left; margin: 5px; padding: 5px; border: #CCC 2px solid;">
							<h3><?php esc_html_e( 'Exclude folders', 'organize-media-library' ); ?></h3>
							<p><?php esc_html_e( 'Exclude the folders that you do not want to be displayed.', 'organize-media-library' ); ?></p>
							<div style="display: block;padding:5px 5px">
							<?php /* translators: Regular expression sample */ ?>
							<div><?php esc_html_e( 'Regular expression is possible.', 'organize-media-library' ); ?> <?php echo esc_html( sprintf( __( 'Sample: Exclude %1$s and %2$s.', 'organize-media-library' ), '/test/test2', '/test3' ) ); ?> [<code>\/test\/test2|\/test3</code>]</div>
							<textarea name="exclude_folders" rows="3" style="width: 100%;"><?php echo esc_textarea( $organizemedialibrary_settings['exclude_folders'] ); ?></textarea>
							</div>
						</div>
						<div style="width: 100%; height: 100%; float: left; margin: 5px; padding: 5px; border: #CCC 2px solid;">
							<h3><?php esc_html_e( 'Make folder', 'organize-media-library' ); ?></h3>
							<?php
							if ( class_exists( 'ExtendMediaUploadAdmin' ) && ! get_option( 'uploads_use_yearmonth_folders' ) ) {
								?>
								<input type="checkbox" name="emu_subdir_change" <?php checked( true, $organizemedialibrary_settings['emu_subdir_change'] ); ?>  value="1" > <?php esc_html_e( 'Make the created folder an upload folder', 'organize-media-library' ); ?>
								<?php
							}
							?>
							<p><?php esc_html_e( 'If you created or deleted a folder in another way, you can leave the field blank and press the following button to apply the changes.', 'organize-media-library' ); ?></p>
							<div style="display: block; padding:5px 5px;">
								<code><?php echo esc_html( $this->upload_path . '/' ); ?></code>
								<input type="text" name="newdir">
							</div>
							<div style="clear: both;"></div>
						</div>
						<?php submit_button( __( 'Make folder', 'organize-media-library' ) . '&' . __( 'Save Changes' ), 'large', 'Submit', false ); ?>
					</form>
				</div>
				<div id="organizemedialibrary-admin-tabs-2">
				<?php $this->credit(); ?>
				</div>
			</div>

			</div>
			<?php
	}

	/** ==================================================
	 * Credit
	 *
	 * @since 1.00
	 */
	private function credit() {

		$plugin_name    = null;
		$plugin_ver_num = null;
		$plugin_path    = plugin_dir_path( __DIR__ );
		$plugin_dir     = untrailingslashit( $plugin_path );
		$slugs          = explode( '/', $plugin_dir );
		$slug           = end( $slugs );
		$files          = scandir( $plugin_dir );
		foreach ( $files as $file ) {
			if ( '.' === $file || '..' === $file || is_dir( $plugin_path . $file ) ) {
				continue;
			} else {
				$exts = explode( '.', $file );
				$ext  = strtolower( end( $exts ) );
				if ( 'php' === $ext ) {
					$plugin_datas = get_file_data(
						$plugin_path . $file,
						array(
							'name'    => 'Plugin Name',
							'version' => 'Version',
						)
					);
					if ( array_key_exists( 'name', $plugin_datas ) && ! empty( $plugin_datas['name'] ) && array_key_exists( 'version', $plugin_datas ) && ! empty( $plugin_datas['version'] ) ) {
						$plugin_name    = $plugin_datas['name'];
						$plugin_ver_num = $plugin_datas['version'];
						break;
					}
				}
			}
		}
		$plugin_version = __( 'Version:' ) . ' ' . $plugin_ver_num;
		/* translators: FAQ Link & Slug */
		$faq       = sprintf( esc_html__( 'https://wordpress.org/plugins/%s/faq', '%s' ), $slug );
		$support   = 'https://wordpress.org/support/plugin/' . $slug;
		$review    = 'https://wordpress.org/support/view/plugin-reviews/' . $slug;
		$translate = 'https://translate.wordpress.org/projects/wp-plugins/' . $slug;
		$facebook  = 'https://www.facebook.com/katsushikawamori/';
		$twitter   = 'https://twitter.com/dodesyo312';
		$youtube   = 'https://www.youtube.com/channel/UC5zTLeyROkvZm86OgNRcb_w';
		$donate    = sprintf( esc_html__( 'https://shop.riverforest-wp.info/donate/', '%s' ), $slug );

		?>
			<span style="font-weight: bold;">
			<div>
		<?php echo esc_html( $plugin_version ); ?> | 
			<a style="text-decoration: none;" href="<?php echo esc_url( $faq ); ?>" target="_blank"><?php esc_html_e( 'FAQ' ); ?></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $support ); ?>" target="_blank"><?php esc_html_e( 'Support Forums' ); ?></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $review ); ?>" target="_blank"><?php sprintf( esc_html_e( 'Reviews', '%s' ), $slug ); ?></a>
			</div>
			<div>
			<a style="text-decoration: none;" href="<?php echo esc_url( $translate ); ?>" target="_blank">
			<?php
			/* translators: Plugin translation link */
			echo sprintf( esc_html__( 'Translations for %s' ), esc_html( $plugin_name ) );
			?>
			</a> | <a style="text-decoration: none;" href="<?php echo esc_url( $facebook ); ?>" target="_blank"><span class="dashicons dashicons-facebook"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $twitter ); ?>" target="_blank"><span class="dashicons dashicons-twitter"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $youtube ); ?>" target="_blank"><span class="dashicons dashicons-video-alt3"></span></a>
			</div>
			</span>

			<div style="width: 250px; height: 180px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
			<h3><?php sprintf( esc_html_e( 'Please make a donation if you like my work or would like to further the development of this plugin.', '%s' ), $slug ); ?></h3>
			<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
			<button type="button" style="margin: 5px; padding: 5px;" onclick="window.open('<?php echo esc_url( $donate ); ?>')"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></button>
			</div>

			<?php

	}

	/** ==================================================
	 * Update wp_options table
	 *
	 * @since 1.0
	 */
	private function options_updated() {

		if ( ! empty( $_POST ) ) {
			$post_nonce_field = 'organizemedialibrary_tabs';
			if ( isset( $_POST[ $post_nonce_field ] ) && ! empty( $_POST[ $post_nonce_field ] ) ) {
				if ( check_admin_referer( 'oml_settings', $post_nonce_field ) ) {
					$organizemedialibrary = new OrganizeMediaLibrary();
					$organizemedialibrary_settings = get_option( $this->wp_options_name() );

					if ( ! empty( $_POST ) ) {
						$newdir = null;
						if ( ! empty( $_POST['newdir'] ) ) {
							$newdir = urldecode( wp_strip_all_tags( wp_unslash( $_POST['newdir'] ) ) );
							$new_realdir = wp_normalize_path( $this->upload_dir ) . '/' . $newdir;
							$mkdir_new_realdir = $organizemedialibrary->mb_encode_multibyte( $new_realdir, $organizemedialibrary_settings['character_code'] );
							if ( ! file_exists( $mkdir_new_realdir ) ) {
								$err_mkdir = @wp_mkdir_p( $mkdir_new_realdir );
								if ( ! $err_mkdir ) {
									/* translators: Error message */
									echo '<div class="notice notice-error is-dismissible"><ul><li>' . esc_html( sprintf( __( 'Unable to create folder[%1$s].', 'organize-media-library' ), wp_normalize_path( $organizemedialibrary->mb_utf8( $mkdir_new_realdir, $organizemedialibrary_settings['character_code'] ) ) ) ) . '</li></ul></div>';
									return;
								} else {
									$organizemedialibrary_settings['dirs'] = json_encode( $organizemedialibrary->scan_dir( $this->upload_dir ) );
									update_option( $this->wp_options_name(), $organizemedialibrary_settings );
									/* translators: Error message */
									echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html( sprintf( __( 'Created folder[%1$s].', 'organize-media-library' ), wp_normalize_path( $organizemedialibrary->mb_utf8( $mkdir_new_realdir, $organizemedialibrary_settings['character_code'] ) ) ) ) . '</li></ul></div>';
									if ( class_exists( 'ExtendMediaUploadAdmin' ) && ! get_option( 'uploads_use_yearmonth_folders' ) && ! empty( $_POST['emu_subdir_change'] ) ) {
										$wp_options_name_emu = 'extendmediaupload_settings_' . get_current_user_id();
										$extendmediaupload_settings = get_option( $wp_options_name_emu );
										$extendmediaupload_settings['subdir'] = '/' . $newdir;
										update_option( $wp_options_name_emu, $extendmediaupload_settings );
										/* translators: Error message */
										echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html( sprintf( __( 'The upload folder has been changed to %s.', 'organize-media-library' ), $extendmediaupload_settings['subdir'] ) ) . '</li></ul></div>';
									}
									return;
								}
							} else {
								/* translators: Error message */
								echo '<div class="notice notice-error is-dismissible"><ul><li>' . esc_html( sprintf( __( 'Folder[%1$s] already exists.', 'organize-media-library' ), wp_normalize_path( $organizemedialibrary->mb_utf8( $mkdir_new_realdir, $organizemedialibrary_settings['character_code'] ) ) ) ) . '</li></ul></div>';
								return;
							}
						}
						if ( ! empty( $_POST['organizemedialibrary_character_code'] ) ) {
							$organizemedialibrary_settings['character_code'] = sanitize_text_field( wp_unslash( $_POST['organizemedialibrary_character_code'] ) );
						}
						if ( ! empty( $_POST['exclude_folders'] ) ) {
							$organizemedialibrary_settings['exclude_folders'] = sanitize_text_field( wp_unslash( $_POST['exclude_folders'] ) );
						} else {
							$organizemedialibrary_settings['exclude_folders'] = null;
						}
						if ( ! empty( $_POST['emu_subdir_change'] ) ) {
							$organizemedialibrary_settings['emu_subdir_change'] = true;
						} else {
							$organizemedialibrary_settings['emu_subdir_change'] = false;
						}
						update_option( $this->wp_options_name(), $organizemedialibrary_settings );
						$organizemedialibrary_settings['dirs'] = json_encode( $organizemedialibrary->scan_dir( $this->upload_dir ) );
						update_option( $this->wp_options_name(), $organizemedialibrary_settings );
						echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html( __( 'Settings' ) . ' --> ' . __( 'Changes saved.' ) ) . '</li></ul></div>';
					}
				}
			}
		}
	}

	/** ==================================================
	 * Media Library Column
	 *
	 * @param array $cols  cols.
	 * @return array $cols
	 * @since 6.0
	 */
	public function muc_column( $cols ) {

		global $pagenow;
		if ( 'upload.php' == $pagenow ) {
			$cols['media_folder'] = __( 'Folder', 'organize-media-library' );
		}

		return $cols;

	}

	/** ==================================================
	 * Media Library Column
	 *
	 * @param string $column_name  column_name.
	 * @param int    $id  id.
	 * @since 6.0
	 */
	public function muc_value( $column_name, $id ) {

		if ( 'media_folder' == $column_name ) {

			$organizemedialibrary_settings = get_option( $this->wp_options_name() );

			$html = null;

			$organizemedialibrary = new OrganizeMediaLibrary();

			$attach_rel_dir = get_post_meta( $id, '_wp_attached_file', true );
			$attach_rel_dir = '/' . untrailingslashit( str_replace( wp_basename( $attach_rel_dir ), '', $attach_rel_dir ) );
			$html .= '<select name="targetdirs[' . $id . ']" style="width: 100%; font-size: small; text-align: left;">';
			$html .= $organizemedialibrary->dir_selectbox( $attach_rel_dir, $organizemedialibrary_settings['character_code'] );
			$html .= '</select>';

			unset( $organizemedialibrary );

			$allowed_html = array(
				'select'  => array(
					'name'  => array(),
					'style'  => array(),
				),
				'option'  => array(
					'value'  => array(),
					'select'  => array(),
					'selected'  => array(),
				),
			);

			echo wp_kses( $html, $allowed_html );

		}

	}

	/** ==================================================
	 * Media Library Search Filter for folders
	 *
	 * @since 6.0
	 */
	public function add_folder_filter() {

		global $wp_list_table;

		if ( empty( $wp_list_table->screen->post_type ) &&
			isset( $wp_list_table->screen->parent_file ) &&
			'upload.php' == $wp_list_table->screen->parent_file ) {
			$wp_list_table->screen->post_type = 'attachment';
		}

		if ( is_object_in_taxonomy( $wp_list_table->screen->post_type, 'media_folder' ) ) {
			$get_media_folder = null;
			if ( isset( $_REQUEST['media_folder'] ) && ! empty( $_REQUEST['media_folder'] ) ) {
				$get_media_folder = sanitize_text_field( wp_unslash( $_REQUEST['media_folder'] ) ); }
			?>
			<select name="media_folder">
				<option value="" 
				<?php
				if ( empty( $get_media_folder ) ) {
					echo 'selected="selected"';}
				?>
				><?php esc_html_e( 'All Folders', 'organize-media-library' ); ?></option>
				<?php
				$terms = get_terms( 'media_folder' );
				foreach ( $terms as $term ) {
					?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" 
											  <?php
												if ( $get_media_folder == $term->slug ) {
													echo 'selected="selected"';}
												?>
					><?php echo esc_html( $term->name ); ?></option>
					<?php
				}
				?>
			</select>
			<?php
		}

	}

	/** ==================================================
	 * Bulk Action Select
	 *
	 * @since 6.0
	 */
	public function custom_bulk_admin_footer() {

		global $pagenow;
		if ( 'upload.php' == $pagenow ) {

			$organizemedialibrary_settings = get_option( $this->wp_options_name() );

			$organizemedialibrary = new OrganizeMediaLibrary();

			$html = '<select name="bulk_folder" style="width: 100%; font-size: small; text-align: left;">';
			$html .= '<option value="">' . __( 'Bulk Select' ) . '</option>';
			$html .= $organizemedialibrary->dir_selectbox( $this->plugin_base_dir, $organizemedialibrary_settings['character_code'] );
			$html .= '</select>';

			unset( $organizemedialibrary );

			$allowed_html = array(
				'select'  => array(
					'name'  => array(),
					'style'  => array(),
				),
				'option'  => array(
					'value'  => array(),
					'select'  => array(),
					'selected'  => array(),
				),
			);

			?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('<option>').val('movefolder').text('<?php esc_html_e( 'Move to selected folder', 'organize-media-library' ); ?>').appendTo("select[name='action']");
					jQuery('<option>').val('movefolder').text('<?php esc_html_e( 'Move to selected folder', 'organize-media-library' ); ?>').appendTo("select[name='action2']");
				});
				jQuery('<?php echo wp_kses( $html, $allowed_html ); ?>').appendTo("#media_folder");
			</script>
			<?php
		}

	}

	/** ==================================================
	 * Bulk Action
	 *
	 * @since 6.0
	 */
	public function custom_bulk_action() {

		if ( ! isset( $_REQUEST['detached'] ) ) {

			/* get the action */
			$wp_list_table = _get_list_table( 'WP_Media_List_Table' );
			$action = $wp_list_table->current_action();

			$allowed_actions = array( 'movefolder' );
			if ( ! in_array( $action, $allowed_actions ) ) {
				return;
			}

			check_admin_referer( 'bulk-media' );

			if ( isset( $_REQUEST['media'] ) ) {
				$post_ids = array_map( 'intval', $_REQUEST['media'] );
			}

			if ( empty( $post_ids ) ) {
				return;
			}

			$sendback = remove_query_arg( array( 'foldermoved', 'message', 'untrashed', 'deleted', 'ids' ), wp_get_referer() );
			if ( ! $sendback ) {
				$sendback = admin_url( "upload.php?post_type=$post_type" );
			}

			$pagenum = $wp_list_table->get_pagenum();
			$sendback = add_query_arg( 'paged', $pagenum, $sendback );

			switch ( $action ) {
				case 'movefolder':
					$foldermoved = 0;
					if ( ! empty( $_REQUEST['targetdirs'] ) ) {
						$target_dirs = array_map( 'wp_strip_all_tags', wp_unslash( $_REQUEST['targetdirs'] ) );
						$target_dirs = array_map( 'urldecode', $target_dirs );
					} else {
						return;
					}
					$messages = array();

					$organizemedialibrary_settings = get_option( $this->wp_options_name() );
					$character_code = $organizemedialibrary_settings['character_code'];

					$organizemedialibrary = new OrganizeMediaLibrary();

					foreach ( $post_ids as $post_id ) {
						$message = $organizemedialibrary->regist( $post_id, $target_dirs[ $post_id ], $character_code );
						if ( $message ) {
							$messages[ $foldermoved ] = $message;
							$foldermoved++;
						}
					}
					unset( $organizemedialibrary );
					$sendback = add_query_arg(
						array(
							'foldermoved' => $foldermoved,
							'ids' => join( ',', $post_ids ),
							'message' => join(
								',',
								$messages
							),
						),
						$sendback
					);
					break;
				default:
					return;
			}

			$sendback = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view' ), $sendback );
			wp_redirect( $sendback );
			exit();

		}

	}

	/** ==================================================
	 * Bulk Action Message
	 *
	 * @since 6.0
	 */
	public function custom_bulk_admin_notices() {

		global $post_type, $pagenow;

		if ( 'upload.php' == $pagenow && 'attachment' == $post_type && isset( $_REQUEST['foldermoved'] ) && 0 < intval( $_REQUEST['foldermoved'] ) && isset( $_REQUEST['message'] ) ) {
			$messages = explode( ',', urldecode( wp_strip_all_tags( wp_unslash( $_REQUEST['message'] ) ) ) );
			$success_count = 0;
			foreach ( $messages as $message ) {
				if ( 'success' === $message ) {
					++$success_count;
				} else {
					echo '<div class="notice notice-error is-dismissible"><ul><li>' . esc_html( $message ) . '</li></ul></div>';
				}
			}
			if ( 0 < $success_count ) {
				/* translators: Success count */
				echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html( sprintf( __( '%1$d media files updated.', 'organize-media-library' ), $success_count ) ) . '</li></ul></div>';
			}
		}

	}

	/** ==================================================
	 * Insert Media Custom Filter enqueue
	 *
	 * @since 6.04
	 */
	public function insert_media_custom_filter() {
		wp_enqueue_script( 'media-library-taxonomy-filter', $this->plugin_base_url . '/js/collection-filter.js', array( 'media-editor', 'media-views' ), '1.00', false );
		wp_localize_script( 'media-library-taxonomy-filter', 'MediaLibraryTaxonomyFilterData', array( 'terms' => get_terms( 'media_folder' ) ) );
		add_action( 'admin_footer', array( $this, 'insert_media_custom_filter_styling' ) );
	}

	/** ==================================================
	 * Insert Media Custom Filter style
	 *
	 * @since 6.04
	 */
	public function insert_media_custom_filter_styling() {
		?>
		<style>
		.media-modal-content .media-frame select.attachment-filters {
			max-width: -webkit-calc(33% - 12px);
			max-width: calc(33% - 12px);
		}
		</style>
		<?php
	}

	/** ==================================================
	 * Notices
	 *
	 * @since 6.31
	 */
	public function notices() {

		if ( $this->is_my_plugin_screen() ) {
			if ( is_multisite() ) {
				$emu_install_url = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=extend-media-upload' );
			} else {
				$emu_install_url = admin_url( 'plugin-install.php?tab=plugin-information&plugin=extend-media-upload' );
			}
			$emu_install_html = '<a href="' . $emu_install_url . '" target="_blank" style="text-decoration: none; word-break: break-all;">Extend Media Upload</a>';
			if ( ! class_exists( 'ExtendMediaUploadAdmin' ) ) {
				/* translators: Extend Media Upload install link*/
				echo '<div class="notice notice-warning is-dismissible"><ul><li>' . wp_kses_post( sprintf( __( 'If you want to add a folder designation function to the media uploader, Please use the %1$s.', 'organize-media-library' ), $emu_install_html ) ) . '</li></ul></div>';
			}
		}

	}

	/** ==================================================
	 * Options name
	 *
	 * @return string $this->wp_options_name()
	 * @since 6.41
	 */
	private function wp_options_name() {
		if ( ! function_exists( 'wp_get_current_user' ) ) {
			include_once( ABSPATH . 'wp-includes/pluggable.php' );
		}
		return 'organizemedialibrary_settings_' . get_current_user_id();
	}

}


