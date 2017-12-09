<?php
/**
 * Template Name: Parallax
 *
 * The template file for displaying rows as parallax sections
 */

get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;
?>

<?php get_footer(); ?>
