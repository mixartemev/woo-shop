<?php
/**
 * Template Name: Full Width
 *
 * The template file for displaying page in full width.
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;

get_footer();
