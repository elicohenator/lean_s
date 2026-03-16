<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

	<main id="content">

    <section class="error-404 not-found">
      <header>
        <h1><?php esc_html_e( '404 Not Found', '_s' ); ?></h1>
        <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to the home page', '_s' ); ?></a></p>
      </header>
    </section>

	</main><!-- #main -->

<?php
get_footer();
