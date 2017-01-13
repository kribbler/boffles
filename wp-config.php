<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'CyPb:3QI|rQEQd0CJU`)2-/hWQ1&-OrWy@kW6X8(|}PV?YSr- 3m##q-~)P*Yl(H');
define('SECURE_AUTH_KEY',  '(jfQ5.rv>L;{yfdjyX.)hlP%qx*F:J#pRG%IJ~?zoDE J.kq34STSq^Puo%6+WX%');
define('LOGGED_IN_KEY',    'Ex++l,itx}l0RyUee>.nBnG;4zijwd+b*ab_~QQ+yO#$JZ],(ZM_9h&KsBp|!!6}');
define('NONCE_KEY',        'U$Y-tFQcxb8+-l#taC|DVZCYi%ACp+*j|_L=<BxCf*Hpg+3-j+BPorMz%c{_(pxV');
define('AUTH_SALT',        '-G`SoO|C@]^l{TJwxqova}+$),JmZ38|F`#+uy*NQ,R10WM|5w-H){tVqDQ4=!x-');
define('SECURE_AUTH_SALT', ':#.GVu+QkB)8:6$J#k~*9,5c*}+0j|Ce}(h8YcH1cMD$;i.O/-x7T=> OZ%=N`2Q');
define('LOGGED_IN_SALT',   'qFW~FIdk^0|5EC/L!{rXRBc-p=;Dy%p# FYP2S->f&@S+/r_i^XmTgydMZA^HIiw');
define('NONCE_SALT',       'Ez;n&^58hkI>5g,vQ6-c)I]tRsvc@QKLx2:h;kJk/inB.2E-BOb_9=3rP{S-MVZS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
