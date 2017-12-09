<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PenShop
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<?php do_action( 'penshop_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner">

		<?php do_action( 'penshop_header' ); ?>

	</header><!-- #masthead -->

	<?php do_action( 'penshop_after_header' ); ?>

	<div id="content" class="site-content">

		<?php do_action( 'penshop_before_content' ); ?>