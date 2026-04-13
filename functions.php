<?php

/**
 * _s functions and definitions
 */

if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('_s_setup')) :

	function _s_setup(): void
	{

		load_theme_textdomain('_s', get_template_directory() . '/languages');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			[
				'primary' => esc_html__('Primary', '_s'),
			]
		);
	}
endif;
add_action('after_setup_theme', '_s_setup');


/**
 * Remove extra image sizes (only affects custom sizes; core sizes are unchanged).
 */
function _s_remove_extra_image_sizes(): void
{
	$keep = ['thumbnail', 'medium', 'large', '2048x2048'];
	foreach (get_intermediate_image_sizes() as $size) {
		if (!in_array($size, $keep, true)) {
			remove_image_size($size);
		}
	}
}
add_action('init', '_s_remove_extra_image_sizes');


/**
 * Enqueue scripts and styles.
 */
function _s_scripts(): void
{
	$template_dir     = get_template_directory();
	$template_dir_uri = get_template_directory_uri();

	wp_enqueue_style('_s-style', get_stylesheet_uri(), [], _S_VERSION);

	$screen_css = $template_dir . '/styles/screen.css';
	if (file_exists($screen_css)) {
		wp_enqueue_style('_s-screen', $template_dir_uri . '/styles/screen.css', [], filemtime($screen_css));
	}

	$scripts_js = $template_dir . '/js/scripts.js';
	if (file_exists($scripts_js)) {
		wp_enqueue_script('_s-scripts', $template_dir_uri . '/js/scripts.js', ['jquery'], filemtime($scripts_js), true);
	}

	$custom_js = $template_dir . '/js/custom.js';
	if (file_exists($custom_js)) {
		wp_enqueue_script('_s-custom', $template_dir_uri . '/js/custom.js', ['jquery'], filemtime($custom_js), true);
	}

	$navigation_js = $template_dir . '/js/navigation.js';
	wp_enqueue_script('_s-navigation', $template_dir_uri . '/js/navigation.js', [], file_exists($navigation_js) ? filemtime($navigation_js) : _S_VERSION, true);

	$php_vars = array(
		'template_directory' => $template_dir_uri,
		'ajax_url'           => admin_url('admin-ajax.php'),
		'ajax_nonce'         => wp_create_nonce('ajax_nonce'),
		'version'            => _S_VERSION,
	);
	$scripts_async = $template_dir . '/js/scripts-async.js';
	$custom_async  = $template_dir . '/js/custom-async.js';
	if (file_exists($scripts_async)) {
		$php_vars['scripts_async_version'] = filemtime($scripts_async);
	}
	if (file_exists($custom_async)) {
		$php_vars['custom_async_version'] = filemtime($custom_async);
	}
	// Localize on navigation so php_vars is always available even without custom.js.
	wp_localize_script('_s-navigation', 'php_vars', $php_vars);
}
add_action('wp_enqueue_scripts', '_s_scripts');


// lean_s custom enhancements (optional)
$enhancements = get_template_directory() . '/inc/enhancements.php';
if (file_exists($enhancements)) {
	require $enhancements;
}

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Theme Customizer.
require get_template_directory() . '/inc/customizer.php';

// Admin-only tweaks (optional).
require get_template_directory() . '/inc/admin.php';

// ACF options and helpers (optional; requires ACF plugin).
require get_template_directory() . '/inc/acf.php';

// Load WooCommerce compatibility file.
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}
