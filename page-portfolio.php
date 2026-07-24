<?php
/**
 * Template Name: Portfolio Page
 * Template Post Type: page
 *
 * Auto-loads for the page with slug "portfolio". This is a thin wrapper that
 * delegates to page-portfolio-override.php so there is a single source of truth
 * for the portfolio content — the same file the template_include router forces
 * for the CPT-archive case (see seawinds_template_router() in functions.php).
 *
 * @package Seawinds
 */

$sw_override = locate_template( 'page-portfolio-override.php' );

if ( $sw_override ) {
	load_template( $sw_override );
}
