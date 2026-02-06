<?php
/**
Plugin Name: Clear All Cache for WP Super Cache 
Plugin URI: https://apasionados.es/blog/vaciar-cache-wp-super-cache-plugin-wordpress-1933/
Description: Clear all cached files of the WP Super Cache plugin directly from the admin menu (option only available to super admins).
Version: 2.4
Author: Apasionados.es
Author URI: https://apasionados.es/
Text Domain: wp-super-cache-clear-cache-menu
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load translations at the right time.
 */
function wpsccc_load_textdomain() {
	load_plugin_textdomain(
		'wp-super-cache-clear-cache-menu',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'init', 'wpsccc_load_textdomain' );

/**
 * Add admin bar menu item if WP Super Cache is active.
 */
function wpsccc_admin_bar_menu( $wp_admin_bar ) {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	if ( ! is_plugin_active( 'wp-super-cache/wp-cache.php' ) ) {
		return;
	}

	if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
		return;
	}

	$wp_admin_bar->add_menu( array(
		'id'    => 'delete-cache-completly',
		'title' => __( 'Clear all cached files', 'wp-super-cache-clear-cache-menu' ),
		'meta'  => array(
			'title' => __( 'Clear all cached files of WP Super Cache', 'wp-super-cache-clear-cache-menu' ),
		),
		'href'  => wp_nonce_url(
			admin_url( 'options-general.php?page=wpsupercache&wp_delete_cache=1&tab=contents' ),
			'wp-cache'
		),
	) );
}
add_action( 'admin_bar_menu', 'wpsccc_admin_bar_menu', 999 );