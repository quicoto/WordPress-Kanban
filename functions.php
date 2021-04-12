<?php
/**
 * kanban functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kanban
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.4' );
}

if ( ! function_exists( 'kanban_setup' ) ) :
	function kanban_setup() {
		add_theme_support( 'automatic-feed-links' );
	}
endif;
add_action( 'after_setup_theme', 'kanban_setup' );

function remove_admin_bar() {
	show_admin_bar(false);
}
add_action('after_setup_theme', 'remove_admin_bar');

function my_deregister_scripts(){
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


/**
 * Enqueue scripts and styles.
 */
function kanban_scripts() {
	wp_enqueue_style( 'kanban-style', get_stylesheet_directory_uri() . '/app/dist/app.css', array(), _S_VERSION );
	wp_dequeue_style( 'wp-block-library' );
	wp_enqueue_script( 'kanban-app', get_stylesheet_directory_uri() . '/app/dist/app.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kanban_scripts' );


require get_template_directory() . '/inc/post-types-taxonomies.php';
require get_template_directory() . '/inc/custom-api.php';
require get_template_directory() . '/inc/disable-emojis.php';
require get_template_directory() . '/inc/cookie-expire.php';
require get_template_directory() . '/inc/redirect-after-login.php';
