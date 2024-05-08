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
define( 'DB_NAME', 'wp-test' );

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
define('WP_ALLOW_REPAIR', true);

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
define( 'AUTH_KEY',         'Sx>.9`FUbveG!9+3h4OU,a$/dq8jE#IW,>6%kal= Vy:2qZwMuUF|!TJ,oRcdYTY' );
define( 'SECURE_AUTH_KEY',  'R?Q/R4<;*6V+e;Y?k%$tZVu5a&4sE[;d]]UU~(EHa7%y6<FWAVG%Uh+:(~{5RBRg' );
define( 'LOGGED_IN_KEY',    '4o`d [>tM7 e7m&}PrQ@TOqwA_]9-1nF;t}3<z/=d$G*$;LTp<Wnb{s1G^CZyRLw' );
define( 'NONCE_KEY',        'wQg@|SyVDs=`.~#@A];wdDBm^y||baQW VC,~8ypd4}viugE]6PX?E+LqT+bg8%=' );
define( 'AUTH_SALT',        'mC1GRd&ixz9krisL0X|{1D5R<`Kz*o?1_~loqFp-=Zi8waG#/y AS}y3a90lZ-R+' );
define( 'SECURE_AUTH_SALT', 'wpc_&i@Wld>eL4D;G7ld4b9SQGhH9>.=<NRC#[pI@y#.RbJZoE*c+5xapo_j>hzu' );
define( 'LOGGED_IN_SALT',   'f5;FbrntH6KO~666/+z#uA`,IzN}h{&AeLZyJny(^zl}DvSFu6!b:sj/PFD7Qe27' );
define( 'NONCE_SALT',       'NL`-B#3Vo339`#0}N?`ZgwQoyd]64t6ro[3i$~m7KK@MVE&*D N^}C1*ZOk/r(rH' );

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
