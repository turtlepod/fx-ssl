<?php
/**
 * Plugin Name: f(x) SSL
 * Plugin URI: http://genbu.me/plugins/fx-ssl/
 * Description: Simple SSL(HTTPS) Plugin.
 * Version: 1.1.0
 * Author: David Chandra Purnama
 * Author URI: http://shellcreeper.com/
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @author David Chandra Purnama <david@genbu.me>
 * @copyright Copyright (c) 2016, Genbu Media
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
**/

/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

/* Set the version constant. */
define( 'FX_SSL_VERSION', '1.1.0' );

/* Set the constant path to the plugin path. */
define( 'FX_SSL_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

/* Set the constant path to the plugin directory URI. */
define( 'FX_SSL_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );


/* Plugins Loaded
------------------------------------------ */

/* Load plugins file */
add_action( 'plugins_loaded', 'fx_ssl_plugins_loaded' );

/**
 * Load plugins file
 * @since 0.1.0
 */
function fx_ssl_plugins_loaded(){

	/* Language */
	load_plugin_textdomain( 'fx-ssl', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	/* Load Settings */
	if( is_admin() ){
		require_once( FX_SSL_PATH . 'includes/settings.php' );
		$fx_ssl_settings = new fx_SSL_Settings();
	}
}

/* Load Functions */
require_once( FX_SSL_PATH . 'includes/functions.php' );


/* Activation and Uninstall
------------------------------------------ */

/* Register activation hook. */
register_activation_hook( __FILE__, 'fx_ssl_activation' );


/**
 * Runs only when the plugin is activated.
 * @since 0.1.0
 */
function fx_ssl_activation() {

	/* Add notice. */
	if ( is_ssl() && force_ssl_admin() && fx_ssl_is_https( get_bloginfo( 'url' ) ) && fx_ssl_is_https( get_bloginfo( 'wpurl' ) ) ) {
		set_transient( 'fx_ssl_notice', 'success', 5 );
		if( get_option( 'fx-ssl', false ) ){
			set_transient( 'fx_ssl_notice', 'active', 5 );
		}
	}
	else{
		set_transient( 'fx_ssl_notice', 'fail', 5 );
	}
}


/* Add admin notice */
add_action( 'admin_notices', 'fx_ssl_admin_notice' );

/**
 * Admin Notice on Activation.
 * @since 0.1.0
 */
function fx_ssl_admin_notice(){
	if( 'fail' === get_transient( 'fx_ssl_notice' ) ){
		?>
		<div class="updated notice is-dismissible">
			<?php echo wpautop( apply_filters( 'fx_ssl_notice_fail', sprintf( _x( 'You need to enable (and enforce) <a href="%s" target="_blank">WordPress administration over SSL</a> and use HTTPS URL in "WordPress Address (URL)" and "Site Address (URL)" in <a href="%s">General Settings</a> to use f(x) SSL plugin.', 'activation notice', 'fx-ssl' ), 'https://codex.wordpress.org/Administration_Over_SSL', admin_url( 'options-general.php' ) ) ) );?>
		</div>
		<?php
		delete_transient( 'fx_ssl_notice' );
	}
	elseif( 'success' === get_transient( 'fx_ssl_notice' ) ){
		?>
		<div class="updated notice is-dismissible">
			<?php echo wpautop( apply_filters( 'fx_ssl_notice_success', sprintf( _x( 'Navigate to <a href="%s">General Settings</a> to activate SSL (HTTPS) in your site.', 'activation notice', 'fx-ssl' ), admin_url( 'options-general.php' ) ) ) );?>
		</div>
		<?php
		delete_transient( 'fx_ssl_notice' );
	}
	elseif( 'active' === get_transient( 'fx_ssl_notice' ) ){
		?>
		<div class="updated notice is-dismissible">
			<?php echo wpautop( apply_filters( 'fx_ssl_notice_active', _x( 'Your site SSL (HTTPS) is active.', 'activation notice', 'fx-ssl' ) ) );?>
		</div>
		<?php
		delete_transient( 'fx_ssl_notice' );
	}
}

