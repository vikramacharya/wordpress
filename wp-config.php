<?php
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
define('DB_NAME', 'assent');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'craftsvilla');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'EzYktreCtwkMXGbHSUVwBPqY3En8HhBIe2RPpnPEfB5BO0Di2CXcWnzy6dBTmXRj');
define('SECURE_AUTH_KEY',  'FNdtrvstI2RWOpY2TzeqKrSqR5bgmbH6VI8TvacvGv78tRaRSDBahQMVyx5YNm8E');
define('LOGGED_IN_KEY',    'PEDJaRyqfca4pGynOp2i0Nh8pR7xQfJSuv3UtqEzLjjS99jQiTx4r8WUoAIW7UU9');
define('NONCE_KEY',        'De0V7FAXvMKTta6CckX21Y1tjzrnO6PdoblCW6OBsVrGuCdk6hlpQPh4ROWaFDVw');
define('AUTH_SALT',        '5fPVzu9vaLOvnRAuDyAfc7BYMLFbakaqbTcQlUddL9y8qHs19tGMpe4XxlXJo9U0');
define('SECURE_AUTH_SALT', 'bIZ2Vi9mcBzUGbhMzOENjbpmKqPxdRwXSDbZIYUFM27ZdkHzFnlhTkjZpwcrAUcI');
define('LOGGED_IN_SALT',   '3azxAVMwKax5elqL5UQF3b1gv4JEob6b1yPm7pKqTxKZ5c85eal9sVIFKDvxWGZy');
define('NONCE_SALT',       'FODMxeGGZimFCMyRtFuB51SilJmfV3SkAiASsS3yeQIBPKqQI7B6nMt5u2P1gQxw');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
