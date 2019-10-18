<?php

// Configuration common to all environments
include_once __DIR__ . '/wp-config.common.php';

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lioninn');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@r!A+??E*&=0$Q`_8Y02Z{pQ2#s]hjQi50gDWJRhrBA,a[|%+MCAk+-_%4i9V16a');
define('SECURE_AUTH_KEY',  'sO/?|a^xh&b~<EJwl2rQB7xO60QcY=v?hsu)o)4y`x^/v_jJ~x./iqJ~-~<ftYCj');
define('LOGGED_IN_KEY',    'P-vz/{C.u$MK#]<hf`gb|RSRP@jSW$N}_kG<+YZTJ&nb_L_q}xPQEm%WdE7-}Pni');
define('NONCE_KEY',        '0lHx@X3z|]UbjQF7.o@/ nBRr{3IMkf$*z;9?=W]=u9hKZ#.IE,};TyL^_|s%>t-');
define('AUTH_SALT',        'DR0:txD|xL7-Gq_9@z9tNq}MRaYW9 mMv[R=KdIwKYajVff=gx,-nEeC!DHNT|Aj');
define('SECURE_AUTH_SALT', 'DcWneCTZ9;H_A=7e|^/|K1QDQJL7oa<m,PZ3#$zwiRWyz%x4lI@i@]E#|;twVs-@');
define('LOGGED_IN_SALT',   '[vM&7]MT+6 4+uk-G!Thl q(WQ2>BLr_: dx5f7QZN5tbQ4/-A=^=;7u*Q|!Fl&l');
define('NONCE_SALT',       '~tH^T5n-4%nxEs+c!FA0~IAT.hNxh~{6hgV4=y,FF--btm~Mdy6_[G]0M{tU2KI=');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hjb01_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

define('VP_ENVIRONMENT', 'default');


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/* Increase Memory Allocated to PHP */
define( 'WP_MEMORY_LIMIT', '512M' );

define('FS_METHOD','direct');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
