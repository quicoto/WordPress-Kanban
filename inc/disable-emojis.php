<?php

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