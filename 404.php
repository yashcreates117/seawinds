<?php
/**
 * 404 template.
 *
 * @package Seawinds
 */

get_header();
?>

<section class="sw-404">
	<div class="sw-404__inner">
		<p class="sw-404__code">404</p>
		<h1 class="sw-404__title"><?php esc_html_e( 'Page Not Found', 'seawinds' ); ?></h1>
		<p class="sw-404__text"><?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved.', 'seawinds' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--gold sw-btn--lg"><?php esc_html_e( 'Back to Home', 'seawinds' ); ?></a>
	</div>
</section>

<?php
get_footer();
