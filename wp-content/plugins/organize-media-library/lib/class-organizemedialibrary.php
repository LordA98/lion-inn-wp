<?php
/**
 * Organize Media Library by Folders
 *
 * @package    Organize Media Library
 * @subpackage OrganizeMediaLibrary Main Functions
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

/** ==================================================
 * Main Functions
 */
class OrganizeMediaLibrary {

	/** ==================================================
	 * Path
	 *
	 * @var $upload_dir  upload_dir.
	 */
	private $upload_dir;

	/** ==================================================
	 * Path
	 *
	 * @var $upload_url  upload_url.
	 */
	private $upload_url;

	/** ==================================================
	 * Path
	 *
	 * @var $upload_path  upload_path.
	 */
	private $upload_path;

	/** ==================================================
	 * Construct
	 *
	 * @since 6.20
	 */
	public function __construct() {

		list($this->upload_dir, $this->upload_url, $this->upload_path) = $this->upload_dir_url_path();

	}

	/** ==================================================
	 * Regist
	 *
	 * @param int    $re_id_attache  re_id_attache.
	 * @param string $target_folder  target_folder.
	 * @param string $character_code  character_code.
	 * @return string $message
	 * @since 1.0
	 */
	public function regist( $re_id_attache, $target_folder, $character_code ) {

		$target_folder = urldecode( $target_folder );
		if ( '/' <> $target_folder ) {
			$target_folder = trailingslashit( $target_folder );}
		$file = get_post_meta( $re_id_attache, '_wp_attached_file', true );
		$filename = wp_basename( $file );
		$current_folder = '/' . str_replace( $filename, '', $file );
		$exts = explode( '.', $filename );
		$ext = end( $exts );

		if ( $target_folder === $current_folder ) {
			return; }

		$re_attache = get_post( $re_id_attache );
		$new_attach_title = $re_attache->post_title;

		$current_file = $this->mb_encode_multibyte( $this->upload_dir . $current_folder . $filename, $character_code );
		$target_file = $this->mb_encode_multibyte( $this->upload_dir . $target_folder . $filename, $character_code );
		if ( file_exists( $current_file ) ) {
			$err_copy1 = @copy( $current_file, $target_file );
			if ( ! $err_copy1 ) {
				/* translators: Error message */
				return sprintf( __( '%1$s: Failed a copy from %2$s to %3$s.', 'organize-media-library' ), $new_attach_title, wp_normalize_path( $this->mb_utf8( $current_file, $character_code ) ), wp_normalize_path( $this->mb_utf8( $target_file, $character_code ) ) );
			}
			unlink( $current_file );
		}

		update_post_meta( $re_id_attache, '_wp_attached_file', ltrim( $target_folder . $filename, '/' ) );

		if ( 'image' === wp_ext2type( $ext ) || 'pdf' === strtolower( $ext ) ) {

			$metadata = wp_get_attachment_metadata( $re_id_attache );

			if ( ! empty( $metadata ) ) {
				foreach ( (array) $metadata as $key1 => $key2 ) {
					if ( 'sizes' === $key1 ) {
						foreach ( $metadata[ $key1 ] as $key2 => $key3 ) {
							$current_thumb_file = $this->mb_encode_multibyte( $this->upload_dir . $current_folder . $metadata['sizes'][ $key2 ]['file'], $character_code );
							$target_thumb_file = $this->mb_encode_multibyte( $this->upload_dir . $target_folder . $metadata['sizes'][ $key2 ]['file'], $character_code );
							if ( file_exists( $current_thumb_file ) ) {
								$err_copy2 = @copy( $current_thumb_file, $target_thumb_file );
								if ( ! $err_copy2 ) {
									/* translators: Error message */
									return sprintf( __( '%1$s: Failed a copy from %2$s to %3$s.', 'organize-media-library' ), $new_attach_title, wp_normalize_path( $this->mb_utf8( $current_thumb_file, $character_code ) ), wp_normalize_path( $this->mb_utf8( $target_thumb_file, $character_code ) ) );
								}
								unlink( $current_thumb_file );
							}
						}
					}
				}
				$metadata['file'] = ltrim( $target_folder . $filename, '/' );
				update_post_meta( $re_id_attache, '_wp_attachment_metadata', $metadata );
			}
		}

		$url_attach = $this->upload_url . $current_folder . $filename;
		$new_url_attach = $this->upload_url . $target_folder . $filename;

		global $wpdb;
		/* Change DB contents */
		$search_url = str_replace( '.' . $ext, '', $url_attach );
		$replace_url = str_replace( '.' . $ext, '', $new_url_attach );

		/* Replace */
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE `$wpdb->posts` SET post_content = replace(post_content, %s, %s)",
				$search_url,
				$replace_url
			)
		);

		/* Change DB Attachement post guid */
		$update_array = array(
			'guid' => $new_url_attach,
		);
		$id_array = array( 'ID' => $re_id_attache );
		$wpdb->show_errors();
		$wpdb->update( $wpdb->posts, $update_array, $id_array, array( '%s' ), array( '%d' ) );
		if ( '' !== $wpdb->last_error ) {
			$message = $wpdb->print_error();
		} else {
			$message = 'success';
		}
		unset( $update_array, $id_array );

		return $message;

	}

	/** ==================================================
	 * Scan directory
	 *
	 * @param string $dir  dir.
	 * @return array $dirlist
	 * @since 1.00
	 */
	public function scan_dir( $dir ) {

		$wp_options_name = 'organizemedialibrary_settings_' . get_current_user_id();
		$organizemedialibrary_settings = get_option( $wp_options_name );

		$excludedir = 'media-from-ftp-tmp'; /* tmp dir for Media from FTP */
		global $blog_id;
		if ( is_multisite() && is_main_site( $blog_id ) ) {
			$excludedir .= '|\/sites\/';
		}
		if ( ! empty( $organizemedialibrary_settings['exclude_folders'] ) ) {
			$excludedir .= '|' . $organizemedialibrary_settings['exclude_folders'];
		}

		$files = scandir( $dir );
		$list = array();
		foreach ( $files as $file ) {
			if ( '.' == $file || '..' == $file ) {
				continue;
			}
			$fullpath = rtrim( $dir, '/' ) . '/' . $file;
			if ( is_dir( $fullpath ) ) {
				if ( ! preg_match( '/' . $excludedir . '/', $fullpath ) ) {
					$list[] = $fullpath;
				}
				$list = array_merge( $list, $this->scan_dir( $fullpath ) );
			}
		}

		arsort( $list );
		return $list;

	}

	/** ==================================================
	 * Directory set
	 *
	 * @return string $oml_dirs
	 * @since 6.41
	 */
	private function oml_dirs() {

		$oml_dirs = null;
		$wp_options_name = 'organizemedialibrary_settings_' . get_current_user_id();
		if ( get_option( $wp_options_name ) ) {
			$organizemedialibrary_settings = get_option( $wp_options_name );
			if ( ! array_key_exists( 'dirs', (array) $organizemedialibrary_settings ) ) {
				$organizemedialibrary_settings['dirs'] = json_encode( $this->scan_dir( $this->upload_dir ) );
				update_option( $wp_options_name, $organizemedialibrary_settings );
			} else {
				if ( empty( $organizemedialibrary_settings['dirs'] ) ) {
					$organizemedialibrary_settings['dirs'] = json_encode( $this->scan_dir( $this->upload_dir ) );
					update_option( $wp_options_name, $organizemedialibrary_settings );
				}
			}
			$oml_dirs = json_decode( $organizemedialibrary_settings['dirs'], true );
		}

		return $oml_dirs;

	}

	/** ==================================================
	 * Directory select box
	 *
	 * @param string $searchdir  searchdir.
	 * @param string $character_code  character_code.
	 * @return string $linkselectbox
	 * @since 3.00
	 */
	public function dir_selectbox( $searchdir, $character_code ) {

		$oml_dirs = $this->oml_dirs();
		if ( ! $oml_dirs ) {
			return;
		}

		$linkselectbox = null;
		foreach ( $oml_dirs as $linkdir ) {
			$linkdirenc = $this->mb_utf8( str_replace( $this->upload_dir, '', $linkdir ), $character_code );
			if ( $searchdir === $linkdirenc ) {
				$linkdirs = '<option value="' . urlencode( $linkdirenc ) . '" selected>' . str_replace( $this->upload_path, '', $linkdirenc ) . '</option>';
			} else {
				$linkdirs = '<option value="' . urlencode( $linkdirenc ) . '">' . str_replace( $this->upload_path, '', $linkdirenc ) . '</option>';
			}
			$linkselectbox = $linkselectbox . $linkdirs;
		}
		if ( '/' === $searchdir ) {
			$linkdirs = '<option value="' . urlencode( '/' ) . '" selected>/</option>';
		} else {
			$linkdirs = '<option value="' . urlencode( '/' ) . '">/</option>';
		}
		$linkselectbox = $linkselectbox . $linkdirs;

		return $linkselectbox;

	}

	/** ==================================================
	 * Real Url
	 *
	 * @param  string $base  base.
	 * @param  string $relationalpath relationalpath.
	 * @return string $realurl realurl.
	 * @since  1.00
	 */
	private function realurl( $base, $relationalpath ) {

		$parse = array(
			'scheme'   => null,
			'user'     => null,
			'pass'     => null,
			'host'     => null,
			'port'     => null,
			'query'    => null,
			'fragment' => null,
		);
		$parse = wp_parse_url( $base );

		if ( strpos( $parse['path'], '/', ( strlen( $parse['path'] ) - 1 ) ) !== false ) {
			$parse['path'] .= '.';
		}

		if ( preg_match( '#^https?://#', $relationalpath ) ) {
			return $relationalpath;
		} elseif ( preg_match( '#^/.*$#', $relationalpath ) ) {
			return $parse['scheme'] . '://' . $parse['host'] . $relationalpath;
		} else {
			$base_path = explode( '/', dirname( $parse['path'] ) );
			$rel_path  = explode( '/', $relationalpath );
			foreach ( $rel_path as $rel_dir_name ) {
				if ( '.' === $rel_dir_name ) {
					array_shift( $base_path );
					array_unshift( $base_path, '' );
				} elseif ( '..' === $rel_dir_name ) {
					array_pop( $base_path );
					if ( count( $base_path ) === 0 ) {
						$base_path = array( '' );
					}
				} else {
					array_push( $base_path, $rel_dir_name );
				}
			}
			$path = implode( '/', $base_path );
			return $parse['scheme'] . '://' . $parse['host'] . $path;
		}

	}

	/** ==================================================
	 * Upload Path
	 *
	 * @return array $upload_dir,$upload_url,$upload_path  uploadpath.
	 * @since 1.00
	 */
	public function upload_dir_url_path() {

		$wp_uploads = wp_upload_dir();

		$relation_path_true = strpos( $wp_uploads['baseurl'], '../' );
		if ( $relation_path_true > 0 ) {
			$relationalpath = substr( $wp_uploads['baseurl'], $relation_path_true );
			$basepath       = substr( $wp_uploads['baseurl'], 0, $relation_path_true );
			$upload_url     = $this->realurl( $basepath, $relationalpath );
			$upload_dir     = wp_normalize_path( realpath( $wp_uploads['basedir'] ) );
		} else {
			$upload_url = $wp_uploads['baseurl'];
			$upload_dir = wp_normalize_path( $wp_uploads['basedir'] );
		}

		if ( is_ssl() ) {
			$upload_url = str_replace( 'http:', 'https:', $upload_url );
		}

		if ( $relation_path_true > 0 ) {
			$upload_path = $relationalpath;
		} else {
			$upload_path = str_replace( site_url( '/' ), '', $upload_url );
		}

		$upload_dir  = untrailingslashit( $upload_dir );
		$upload_url  = untrailingslashit( $upload_url );
		$upload_path = untrailingslashit( $upload_path );

		return array( $upload_dir, $upload_url, $upload_path );

	}

	/** ==================================================
	 * Multibyte Initialize
	 *
	 * @param string $character_code  character_code.
	 * @since 5.02
	 */
	public function mb_initialize( $character_code ) {

		if ( function_exists( 'mb_language' ) && 'none' <> $character_code ) {
			if ( 'ja' === get_locale() ) {
				mb_language( 'Japanese' );
			} else if ( 'en_US' === get_locale() ) {
				mb_language( 'English' );
			} else {
				mb_language( 'uni' );
			}
		}

	}

	/** ==================================================
	 * Multibyte Convert
	 *
	 * @param string $str  str.
	 * @param string $character_code  character_code.
	 * @return string $str
	 * @since 5.10
	 */
	public function mb_encode_multibyte( $str, $character_code ) {

		if ( function_exists( 'mb_language' ) && 'none' <> $character_code ) {
			$str = mb_convert_encoding( $str, $character_code, 'auto' );
		}

		return $str;

	}

	/** ==================================================
	 * Multibyte UTF-8
	 *
	 * @param string $str  str.
	 * @param string $character_code  character_code.
	 * @return string $str
	 * @since 5.10
	 */
	public function mb_utf8( $str, $character_code ) {

		if ( function_exists( 'mb_convert_encoding' ) && 'none' <> $character_code ) {
			$str = mb_convert_encoding( $str, 'UTF-8', 'auto' );
		}

		return $str;

	}

}


