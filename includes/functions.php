<?php
/**
 * f(x) SSL
 * @since 0.1.0
**/

/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Check if SSL enabled
 * @since 0.1.0
 */
function fx_ssl_active(){
	if( force_ssl_admin() && get_option( 'fx-ssl', false ) && fx_ssl_is_https( get_option( 'home' ) ) && fx_ssl_is_https( get_option( 'siteurl' ) ) ){
		return true;
	}
	return false;
}

/**
 * Check if an URL is HTTPS
 * @since 0.1.0
 */
function fx_ssl_is_https( $url ){
	$url = esc_url( $url );
	if ( strpos( $url, 'https://' ) !== false ) {
		return true;
	}
	return false;
}

add_action( 'init', 'fx_ssl_init' );


/**
 * Init Hook
 * @since 0.1.0
 */
function fx_ssl_init(){

	if( fx_ssl_active() && !is_admin() ){

		/* Redirect to HTTPS */
		add_action( 'template_redirect', 'fx_ssl_template_redirect' );

		/* Replace URL to use HTTPS */
		add_action( 'template_redirect', 'fx_ssl_fix_url_init' );

	}
}


/**
 * Redirect Front End To HTTPS
 * @since 0.1.0
**/
function fx_ssl_template_redirect(){

	/* If not loaded using HTTPS, redirect to HTTPS Url */
	if ( !is_ssl() ) {
		wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 302 );
		exit();
	}
}

/**
 * Replace HTTP URL to HTTPS
 * @since 0.1.0
 */
function fx_ssl_fix_url_init(){

	/* Only filter if the page is loaded using SSL/HTTPS */
	if( is_ssl() ){

		/* === CONTENT === */

		/* Filter the excerpt. */
		add_filter( 'get_the_excerpt', 'fx_ssl_fix_url', 99 );

		/* Filter the content. */
		add_filter( 'the_content', 'fx_ssl_fix_url', 99 );

		/* === ELEMENTS === */

		/* Widget Text */
		add_filter( 'widget_text', 'fx_ssl_fix_url', 99 );

		/* Navigation Menus */
		add_filter( 'wp_nav_menu', 'fx_ssl_fix_url', 99 );

		/* === THEME === */

		/* Template Directory URI */
		add_filter( 'template_directory_uri', 'fx_ssl_fix_url', 99 );

		/* Stylesheet Directory URI */
		add_filter( 'stylesheet_directory_uri', 'fx_ssl_fix_url', 99 );

		/* === THUMBNAIL === */

		/* Get The Image Script */
		add_filter( 'get_the_image', 'fx_ssl_fix_url', 99 );

		/* Filter Post Thumbnail */
		add_filter( 'post_thumbnail_html', 'fx_ssl_fix_url', 99 );

		/* === URLS === */

		/* esc_url() and esc_url_raw() */
		add_filter( 'clean_url', 'fx_ssl_fix_url', 99 );

		/* set_url_scheme() */
		add_filter( 'set_url_scheme', 'fx_ssl_fix_url', 99 );

		/* plugins_url() */
		add_filter( 'plugins_url', 'fx_ssl_fix_url', 99 );

	}
}


/**
 * Replace HTTP to HTTPS
 * @since 0.1.0
 */
function fx_ssl_fix_url( $content ){
	$domain = '';
	if ( isset( $_SERVER["HTTP_HOST"] ) && !empty( $_SERVER["HTTP_HOST"] ) ){
		$domain = trim( strtolower( $_SERVER["HTTP_HOST"] ) );
	}

	/* Check */
	if( !empty( $domain ) ){

		/* Text Format */
		$content = str_replace( 'http://' . $domain, 'https://' . $domain, $content );

		/* URL Encoded Format */
		$content = str_replace( urlencode( 'http://' . $domain ), urlencode( 'https://' . $domain ), $content );
	}

	return apply_filters( 'fx_ssl_fix_url', $content );
}

