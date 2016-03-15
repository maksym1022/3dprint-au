<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dprinta_new');

/** MySQL database username */
define('DB_USER', 'dprinta_new');

/** MySQL database password */
define('DB_PASSWORD', 'RvJdyZb$^S]t');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '4W(lo!&Ub6BP1(IrgPX9nB9tk^4uo@2dr7%7$AK12%24D9w#3wEubH)APbGNR6CW');
define('SECURE_AUTH_KEY',  '1d!8V&XfDy8OO(FHWT8fDyd11X*Gi602!k)ulNfQZl@JXGRwel6MAJD1Z$*hEg!7');
define('LOGGED_IN_KEY',    'k92Q4jC9zjLIeC82KM6!QxZt9t*zQ*IFd8OtJ8q7FrUQjBVXn8MdMtL7FI*Lb1yU');
define('NONCE_KEY',        'Ooclu6V7@N2p%8%^!c@MGQHtH7CZ267QrAqOko@QsHOWE$RY5)5cukqfo4&g*Y51');
define('AUTH_SALT',        '(NX0)bYz^utwKwHfGDoqr*q)*VzkZF#t^BRMXgBe&&#d!oT^OE$KD3)VURmF@qR6');
define('SECURE_AUTH_SALT', 'dwXql@Nss*ZdreqUTduIWPCGivBGE5Wo)AtIEpe0Yj#5ytAYONtxIo9J&)kffuq@');
define('LOGGED_IN_SALT',   'R90MH2E$W)Yr2eCZ%BfBi)xrl*jK(EimsLIf9PWqKM3XjvpZF^v5T28Y2EwLscuZ');
define('NONCE_SALT',       'Liz9y^8N4oZ9iXe4Rz5w@QcdCf@iR9mCoIOoz9oQdU@Pv)ro&9hqkguPifqrQBZv');
define('WP_MEMORY_LIMIT', '96M');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

?>
