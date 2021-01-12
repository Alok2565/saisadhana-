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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sai_sadhana' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7r:^)xq5/aOX]]EIgALA-jA 2kAO?z.qA5^yMp%Ns.xoiNh(z*l7@EX.c%X`CAo2' );
define( 'SECURE_AUTH_KEY',  '[tKAV)-,h6BQ-HgN::ujxt~r{aU5D_ncEov!HfWzw4B}M4Dlvi]`<J=zaZr?+n(t' );
define( 'LOGGED_IN_KEY',    'b`J11t|w/RH>jRMV9.g[z~!u^;usXiPZi!g!v>@{/356Z/KB-gdWUkmz@|!#Po2.' );
define( 'NONCE_KEY',        ']iiaGF9q3o3UsOZ{]*-6=}ftg#k-ih_ol/B;]gz<;GTNGRrz!ORun#grZG{9].9-' );
define( 'AUTH_SALT',        'mMKrN (T/3*,V3jQ>}Kw2k.>5x~UQu9Dc3?xoLZ^T3dmB*TK/vc1yzC`J$ai-W}@' );
define( 'SECURE_AUTH_SALT', '!&!|_.E%|4|dqUE1A1zeDJqcON)nQl#>Iw $reYD{z~6RymXY?X5|JQnJ:i21Q+6' );
define( 'LOGGED_IN_SALT',   'Y(SMK<&P2&!gcBZkN2P9d&nuJbPx=v}-wwlr7sr#c#1O<0YP!2HQ9zFNi>v|v1X3' );
define( 'NONCE_SALT',       'WjDrt*zJh44mep3Wr.dn:NB{.ly#6T%R:Ux+j VR12|p4O~YS@%[;ap5xf=%Wy`U' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
