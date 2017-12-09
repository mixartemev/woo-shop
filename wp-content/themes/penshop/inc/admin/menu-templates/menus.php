<# if ( data.depth == 0 ) { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'penshop' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'penshop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'penshop' ) ?>" data-panel="background"><?php esc_html_e( 'Background', 'penshop' ) ?></a>
	<div class="separator"></div>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'penshop' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'penshop' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Setting', 'penshop' ) ?>" data-panel="settings"><?php esc_html_e( 'Settings', 'penshop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Content', 'penshop' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'penshop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'penshop' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'penshop' ) ?></a>
<# } else { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'penshop' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'penshop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'penshop' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'penshop' ) ?></a>
<# } #>
