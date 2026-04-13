<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Clean WPCF7 Formatting
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function _s_pingback_header(): void {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', '_s_pingback_header' );
