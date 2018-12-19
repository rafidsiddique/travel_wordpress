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
define('DB_NAME', 'travel');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Y<Jw8b>&#|BYk?v~PJe?-s16zm^s7PRjT,2wr(JU2|=`spI?fxcfe{%mB*:v[kW.');
define('SECURE_AUTH_KEY',  'h,M)`yR0@K;-ckRdADP(MO:3Vl>ch.Y&4/D<iq}4)gwcpIm;@_G=z/Tvw1Y|#|tm');
define('LOGGED_IN_KEY',    '0(%yAb)`<He-H]Zx/9n.s<:^&B-pe4g}C&I8x@mhQtbN^+| 5#@U/vV!^}Q/dToF');
define('NONCE_KEY',        'B@kNPdC pnCbtp~0GgVY[pw:8YFdy`erifa1S7@,M^HrOG$JPL43iDFt?jS,ng T');
define('AUTH_SALT',        '^2>b3CLo=5}.8C#6;zo)k*wihlF(8[7SU!i!Bti,Ge9GduKZX)y~)C?~n}A[[B$?');
define('SECURE_AUTH_SALT', 'q#/VyKWd|xl6{q2hJsOh.C*?@M3NlctgjI4$0P7g@=8m3r(gcY +4y;^},c:Z?{V');
define('LOGGED_IN_SALT',   'uT<s(-t~Fv#_LvxsJmh);|Jz2MB8J;3uygDXi1u),hG$5VFqns[^3$8A1.Q}Y^~e');
define('NONCE_SALT',       'Y*GD,]r^U*|I):CyX^cvQ8nKys?p@X~=r/co#`7`:<|N]c_0&fs$Z05_;fxR`lg3');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_travel';

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
