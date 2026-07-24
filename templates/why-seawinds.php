<?php
/**
 * "Why Sea Winds" section — reused on homepage and About page.
 *
 * @package Seawinds
 */

$sw_points = array(
	array(
		'num'   => '01',
		'title' => 'In-House Fabrication',
		'desc'  => 'Full control from concept to completion, zero outsourcing.',
	),
	array(
		'num'   => '02',
		'title' => '20+ Years Experience',
		'desc'  => 'Trusted by Dubai\'s leading brands since 2003.',
	),
	array(
		'num'   => '03',
		'title' => 'End-to-End Execution',
		'desc'  => 'Design, fabricate, deliver and install — all under one roof.',
	),
	array(
		'num'   => '04',
		'title' => 'Quality Excellence',
		'desc'  => 'Technically qualified teams delivering precision craftsmanship.',
	),
);

$sw_why_title = ( isset( $args['title'] ) && $args['title'] ) ? $args['title'] : 'Why Sea Winds';
$sw_why_light = ( isset( $args['variant'] ) && 'light' === $args['variant'] );
$sw_why_bg    = $sw_why_light ? 'sw-section--light sw-why--light' : 'sw-section--dark';
$sw_why_tcls  = $sw_why_light ? 'sw-section__title' : 'sw-section__title sw-section__title--light';
?>
<section class="sw-section sw-why <?php echo esc_attr( $sw_why_bg ); ?>">
	<div class="sw-container">
		<div class="sw-section__head sw-animate" data-anim="fadeUp">
			<h2 class="<?php echo esc_attr( $sw_why_tcls ); ?>"><?php echo esc_html( $sw_why_title ); ?></h2>
		</div>

		<div class="sw-why__grid sw-stagger">
			<?php foreach ( $sw_points as $p ) : ?>
				<div class="sw-why__item sw-animate" data-anim="fadeUp">
					<span class="sw-why__num"><?php echo esc_html( $p['num'] ); ?></span>
					<h3 class="sw-why__title"><?php echo esc_html( $p['title'] ); ?></h3>
					<p class="sw-why__desc"><?php echo esc_html( $p['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
