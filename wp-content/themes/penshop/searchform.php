<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'penshop' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'penshop' ) ?>" value="<?php get_search_query() ?>" name="s" autocomplete="off" />
	</label>
	<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
</form>