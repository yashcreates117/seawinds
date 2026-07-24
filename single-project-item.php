<?php
/**
 * Single "project item" template.
 *
 * `project_item` is registered as a taxonomy on the `project` post type, so
 * WordPress routes its single project posts through single-project.php. This
 * file exists for completeness (and forward-compatibility if a dedicated
 * project-item post type is ever introduced) and simply reuses the premium
 * single-project layout.
 *
 * @package Seawinds
 */

$sw_single_project = locate_template( 'single-project.php' );

if ( $sw_single_project ) {
	load_template( $sw_single_project );
} else {
	// Fallback to the default single template.
	get_template_part( 'single' );
}
