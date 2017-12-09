<# var itemId = data.data['menu-item-db-id']; #>
<div id="smm-panel-background" class="smm-panel-background smm-panel">
	<p class="background-image">
		<label><?php esc_html_e( 'Background Image', 'penshop' ) ?></label><br>
		<span class="background-image-preview">
			<# if ( data.megaData.background.image ) { #>
				<img src="{{ data.megaData.background.image }}">
			<# } #>
		</span>

		<button type="button" class="button remove-button <# if ( ! data.megaData.background.image ) { print( 'hidden' ) } #>"><?php esc_html_e( 'Remove', 'penshop' ) ?></button>
		<button type="button" class="button upload-button" id="background_image-button"><?php esc_html_e( 'Select Image', 'penshop' ) ?></button>

		<input type="hidden" name="{{ smm.getFieldName( 'background.image', itemId ) }}" value="{{ data.megaData.background.image }}">
	</p>

	<p class="background-color">
		<label><?php esc_html_e( 'Background Color', 'penshop' ) ?></label><br>
		<input type="text" class="background-color-picker" name="{{ smm.getFieldName( 'background.color', itemId ) }}" value="{{ data.megaData.background.color }}">
	</p>

	<p class="background-repeat">
		<label><?php esc_html_e( 'Background Repeat', 'penshop' ) ?></label><br>
		<select name="{{ smm.getFieldName( 'background.repeat', itemId ) }}">
			<option value="no-repeat" {{ 'no-repeat' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'No Repeat', 'penshop' ) ?></option>
			<option value="repeat" {{ 'repeat' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile', 'penshop' ) ?></option>
			<option value="repeat-x" {{ 'repeat-x' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile Horizontally', 'penshop' ) ?></option>
			<option value="repeat-y" {{ 'repeat-y' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile Vertically', 'penshop' ) ?></option>
		</select>
	</p>

	<p class="background-position background-position-x">
		<label><?php esc_html_e( 'Background Position', 'penshop' ) ?></label><br>

		<select name="{{ smm.getFieldName( 'background.position.x', itemId ) }}">
			<option value="left" {{ 'left' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Left', 'penshop' ) ?></option>
			<option value="center" {{ 'center' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Center', 'penshop' ) ?></option>
			<option value="right" {{ 'right' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Right', 'penshop' ) ?></option>
			<option value="custom" {{ 'custom' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'penshop' ) ?></option>
		</select>

		<input
			type="text"
			name="{{ smm.getFieldName( 'background.position.custom.x', itemId ) }}"
			value="{{ data.megaData.background.position.custom.x }}"
			class="{{ 'custom' != data.megaData.background.position.x ? 'hidden' : '' }}">
	</p>

	<p class="background-position background-position-y">
		<select name="{{ smm.getFieldName( 'background.position.y', itemId ) }}">
			<option value="top" {{ 'top' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Top', 'penshop' ) ?></option>
			<option value="center" {{ 'center' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Middle', 'penshop' ) ?></option>
			<option value="bottom" {{ 'bottom' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Bottom', 'penshop' ) ?></option>
			<option value="custom" {{ 'custom' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'penshop' ) ?></option>
		</select>
		<input
			type="text"
			name="{{ smm.getFieldName( 'background.position.custom.y', itemId ) }}"
			value="{{ data.megaData.background.position.custom.y }}"
			class="{{ 'custom' != data.megaData.background.position.y ? 'hidden' : '' }}">
	</p>

	<p class="background-attachment">
		<label><?php esc_html_e( 'Background Attachment', 'penshop' ) ?></label><br>
		<select name="{{ smm.getFieldName( 'background.attachment', itemId ) }}">
			<option value="scroll" {{ 'scroll' == data.megaData.background.attachment ? 'selected="selected"'  : '' }}><?php esc_html_e( 'Scroll', 'penshop' ) ?></option>
			<option value="fixed" {{ 'fixed' == data.megaData.background.attachment ? 'selected="selected"'  : '' }}><?php esc_html_e( 'Fixed', 'penshop' ) ?></option>
		</select>
	</p>

	<p class="background-size">
		<label><?php esc_html_e( 'Background Size', 'penshop' ) ?></label><br>
		<select name="{{ smm.getFieldName( 'background.size', itemId ) }}">
			<option value=""><?php esc_html_e( 'Default', 'penshop' ) ?></option>
			<option value="cover" {{ 'cover' == data.megaData.background.size ? 'selected="selected"' : '' }}><?php esc_html_e( 'Cover', 'penshop' ) ?></option>
			<option value="contain" {{ 'contain' == data.megaData.background.size ? 'selected="selected"' : '' }}><?php esc_html_e( 'Contain', 'penshop' ) ?></option>
		</select>
	</p>
</div>