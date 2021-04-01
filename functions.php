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
	define( '_S_VERSION', '1.0.0' );
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
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
 }
add_action( 'init', 'disable_emojis' );

/**
 * Enqueue scripts and styles.
 */
function kanban_scripts() {
	wp_enqueue_style( 'kanban-style', get_stylesheet_directory_uri() . '/app/dist/app.css', array(), _S_VERSION );
	wp_dequeue_style( 'wp-block-library' );
	wp_enqueue_script( 'kanban-app', get_stylesheet_directory_uri() . '/app/dist/app.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'kanban-chunk-vendors', get_stylesheet_directory_uri() . '/app/dist/chunk-vendors.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kanban_scripts' );

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Items', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Item', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Kanban Items', 'text_domain' ),
		'name_admin_bar'        => __( 'Items', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Item', 'text_domain' ),
		'description'           => __( 'Item Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-clipboard',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'item', $args );

}
add_action( 'init', 'custom_post_type', 0 );

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Boards', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Board', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Boards', 'text_domain' ),
		'all_items'                  => __( 'All Boards', 'text_domain' ),
		'parent_item'                => __( 'Parent Board', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Board:', 'text_domain' ),
		'new_item_name'              => __( 'New Board Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Board', 'text_domain' ),
		'edit_item'                  => __( 'Edit Board', 'text_domain' ),
		'update_item'                => __( 'Update Board', 'text_domain' ),
		'view_item'                  => __( 'View Board', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate boards with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove boards', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Boards', 'text_domain' ),
		'search_items'               => __( 'Search Boards', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No boards', 'text_domain' ),
		'items_list'                 => __( 'Boards list', 'text_domain' ),
		'items_list_navigation'      => __( 'Boards list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'board', array( 'item' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );