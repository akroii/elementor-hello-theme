<?php
/**
 * Elementor Hello Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $content_width ) ) {
	$content_width = 800; // pixels
}

/*
 * Set up theme support
 */
if ( ! function_exists( 'elementor_hello_theme_setup' ) ) {
	function elementor_hello_theme_setup() {
		if ( apply_filters( 'elementor_hello_theme_load_textdomain', true ) ) {
			load_theme_textdomain( 'elementor-hello-theme', get_template_directory() . '/languages' );
		}

		if ( apply_filters( 'elementor_hello_theme_register_menus', true ) ) {
			register_nav_menus( array( 'menu-1' => __( 'Primary', 'elementor-hello-theme' ) ) );
		}

		if ( apply_filters( 'elementor_hello_theme_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'custom-logo' );
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );
			add_theme_support( 'custom-logo', array(
				'height' => 100,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			) );

			/*
			 * WooCommerce:
			 */
			if ( apply_filters( 'elementor_hello_theme_add_woocommerce_support', true ) ) {
				// WooCommerce in general:
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0):
				// zoom:
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox:
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe:
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'elementor_hello_theme_setup' );

/*
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'elementor_hello_theme_scripts_styles' ) ) {
	function elementor_hello_theme_scripts_styles() {
		if ( apply_filters( 'elementor_hello_theme_enqueue_style', true ) ) {
			wp_enqueue_style( 'elementor-hello-theme-style', get_stylesheet_uri() );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'elementor_hello_theme_scripts_styles' );

/*
 * Register Elementor Locations
 */
if ( ! function_exists( 'elementor_hello_theme_register_elementor_locations' ) ) {
	function elementor_hello_theme_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'elementor_hello_theme_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'elementor_hello_theme_register_elementor_locations' );
// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// First, we remove all the RSS feed links from wp_head using remove_action
remove_action( 'wp_head','feed_links', 2 );
remove_action( 'wp_head','feed_links_extra', 3 );

// Resource Hints is a rather new W3C specification that “defines the dns-prefetch,
// preconnect, prefetch, and prerender relationships of the HTML Link Element (<link>)”.
// These can be used to assist the browser in the decision process of which origins it
// should connect to, and which resources it should fetch and preprocess to improve page performance.
remove_action( 'wp_head', 'wp_resource_hints', 2 );

// Sends a Link header for the REST API.
// https://developer.wordpress.org/reference/functions/rest_output_link_header/
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

// Outputs the REST API link tag into page header.
// https://developer.wordpress.org/reference/functions/rest_output_link_wp_head/
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

// https://developer.wordpress.org/reference/functions/wp_oembed_add_discovery_links/
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// WordPress Page/Post Shortlinks
// URL shortening is sometimes useful, but this automatic ugly url
// in your header is useless. There is no reason to keep this. None.
remove_action( 'wp_head', 'wp_shortlink_wp_head');

// Weblog Client Link
// Are you editing your WordPress blog using your browser?
// Then you are not using a blog client and this link can probably be removed.
// This link is also used by a few 3rd party sites/programs that use the XML-RPC request formats.
// One example is the Flickr API. So if you start having trouble with a 3rd party service that
// updates your blog, add this back in. Otherwise, remove it.
remove_action ('wp_head', 'rsd_link');

// Windows Live Writer Manifest Link
// If you don’t know what Windows Live Writer is (it’s another blog editing client), then remove this link.
remove_action( 'wp_head', 'wlwmanifest_link');

// WordPress Generator (with version information)
// This announces that you are running WordPress and what version you are using. It serves no purpose.
remove_action('wp_head', 'wp_generator');
