<?php
/**
 * Learn based off Monochrome Pro.
 *
 * This file adds functions to the Learn Theme.
 *
 * @package Learn
 * @author  Maker Media
 * @license GPL-2.0+
 * @link    https://github.com/Make-Magazine/makehub
 */

add_action( 'genesis_meta', 'learn_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function learn_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) ) {

		// Enqueue scripts and styles.
		add_action( 'wp_enqueue_scripts', 'learn_enqueue_front_script_styles', 1 );

		// Add front-page body class.
		add_filter( 'body_class', 'learn_body_class' );

		// Force full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add front page widgets.
		add_action( 'genesis_before_loop', 'learn_front_page_widgets' );

	}

}

// Define scripts and styles.
function learn_enqueue_front_script_styles() {

	wp_enqueue_script( 'learn-front-script', get_stylesheet_directory_uri() . '/js/front-page.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'learn-front-styles', get_stylesheet_directory_uri() . '/style-front.css' );

}

// Add front-page body class.
function learn_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

// Add markup for front page widgets.
function learn_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'learn' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div class="front-page-1 image-section"><div class="flexible-widgets widget-area fadeup-effect' . learn_widget_area_class( 'front-page-1' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div class="front-page-2 solid-section"><div class="flexible-widgets widget-area fadeup-effect' . learn_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div class="front-page-3 image-section"><div class="flexible-widgets widget-area fadeup-effect' . learn_widget_area_class( 'front-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div class="front-page-4 solid-section"><div class="flexible-widgets widget-area fadeup-effect' . learn_widget_area_class( 'front-page-4' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Run the Genesis loop.
genesis();
