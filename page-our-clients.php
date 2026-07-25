<?php
/**
 * Template Name: Clients Page
 * Template Post Type: page
 *
 * Auto-loads for the page with slug "our-clients".
 *
 * @package Seawinds
 */

get_header();

$sw_logos = array(
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_c0c2d47b2bba4b15887ab33350a836e0mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_4888bbb5cfbc4e5a9ccca4e4f552dd6amv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_ba6d1bc6c8804b8aa2ffdc4dcfa8227fmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_c0a5505d62ed4ff1bb1e370ea5b0d69emv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_a8e2089e80794c9b9ca4e632b31f7ab6mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_97b0df9abd17404d99c0b28499e3bc49mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_4f7979174d9944e4b89f674db8363256mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_222dbd7a67184ec9b4f96d1823914f9cmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_aad6bbd35e584641b23139596d6a319bmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_5b499f6b466b43e1a6c095598a07c1dfmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_6c8be014eae9489e9b250f2feb95e3f9mv2.avif',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_f34ea506c8a94fe98b12b170c865b082mv2-1.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-03-110746.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_1ffd0d480a9741348fa30a901e10d10d_mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_5a95d311224247dca2296a3392ec0f4c_mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_f342184c0997411b8e9ccd033a334573_mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_ab974eb2ffe44063aab7f2959724e874_mv2.png',
);
?>

<?php // ---- Standard page hero (no banner image), consistent with other pages ---- ?>
<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Our Partners', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Our Clients', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-section sw-section--light">
	<div class="sw-container">
		<div class="sw-clients-grid sw-stagger">
			<?php foreach ( $sw_logos as $logo ) : ?>
				<div class="sw-client-box sw-animate" data-anim="fadeIn">
					<img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'Client logo', 'seawinds' ); ?>" loading="lazy" decoding="async" draggable="false">
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
