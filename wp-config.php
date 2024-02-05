<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'policememorial' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '(Vfquz6B{)48yVI`$uU+&=^oJN}ffZh0^rK%&$TB<ngdb#R}J^2z1|$wp[Rs18@C' );
define( 'SECURE_AUTH_KEY',  ',Z`SFR)f$71U0Q6>u(?MPG&kj^v=.C<peBQV8R{mFwUT&MDoA#5pwajg5CCr JK_' );
define( 'LOGGED_IN_KEY',    '8]P}#,P)[m5l7$)4K7vj=?rKl508pA:@*zB1kz3n&-7Z~*4# 6f3q)qk|E2_y,I(' );
define( 'NONCE_KEY',        ')+x|D&(hlah)M~Ux&tHw#m9bhaZ0b= 9vn ZuJ5Pj5jh@ cXh(#i#OM~OWY{j&TJ' );
define( 'AUTH_SALT',        '.}l@lmdfbcrI9t-Ld!xmr[q^SG6j8y}|O}[f2vhCP,X`QDRR5/K5hCSAd`<c<J8>' );
define( 'SECURE_AUTH_SALT', 'B$cG5W)05[(lh~m1lNI|UuE)V8y!6N{W3xFeIHZ(k}#5nd~VDU;!_1rLx]oQ.cS@' );
define( 'LOGGED_IN_SALT',   't4lt-zsX&3O-ZcM&7lk3U`!I@^Y])T+vO=wpY/l#gjOKzT-vEv11TK01[WFMTwzS' );
define( 'NONCE_SALT',       'YaZEumT`v#ah(WWH0iF0P?|15)jFsb^oh?Zu%vRT_#N#W520HMW&9%C= i:=k-OJ' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
