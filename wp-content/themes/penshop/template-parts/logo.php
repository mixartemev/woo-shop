<?php
/**
 * The template part for displaying the main logo on header
 *
 * @package PenShop
 */

$logo_type = penshop_get_option( 'logo_type' );

if ( 'text' == $logo_type ) :
	$logo = penshop_get_option( 'logo_text' );
else:
	$logo        = penshop_get_option( 'logo' );
	$logo        = $logo ? $logo : get_template_directory_uri() . '/assets/images/logo.png';
	$logo_width  = penshop_get_option( 'logo_width' );
	$logo_width  = $logo_width ? ' width="' . esc_attr( $logo_width ) . '"' : '';
	$logo_height = penshop_get_option( 'logo_height' );
	$logo_height = $logo_height ? ' height="' . esc_attr( $logo_height ) . '"' : '';
endif;
?>

<a href="<?php echo esc_url( home_url() ) ?>" class="logo">
	<?php if ( 'text' == $logo_type ) : ?>
		<span class="logo-text"><?php echo esc_html( $logo ) ?></span>
	<?php else : ?>
		<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" <?php echo $logo_width . $logo_height ?>>
	<?php endif; ?>
</a>

<?php if ( is_front_page() && is_home() ) : ?>
	<h1 class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	</h1>
<?php else : ?>
	<p class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	</p>
<?php endif; ?>

<?php if ( ( $description = get_bloginfo( 'description', 'display' ) ) && penshop_get_option( 'logo_description' ) ) : ?>
	<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
<?php endif; ?>