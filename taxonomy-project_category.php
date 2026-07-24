<?php
/**
 * Taxonomy template router for `project_category`.
 *
 * WordPress builds taxonomy template names from the taxonomy's registered
 * name (project_category, with an underscore), so this is the file the
 * template hierarchy actually loads for /project-cat/<term>/ archives.
 * It simply loads the human-named template file that holds the markup.
 *
 * @package Seawinds
 */

$sw_tax_template = locate_template( 'taxonomy-project-category.php' );

if ( $sw_tax_template ) {
	load_template( $sw_tax_template );
} else {
	get_template_part( 'archive', 'project' );
}
