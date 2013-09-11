<?php

/**
 * Class MEXP_Wistia_Template
 */
class MEXP_Wistia_Template extends MEXP_Template {

	/**
	 * Template for single elements returned from the API
	 *
	 * @param string $id the id of the view
	 * @param string $tab the tab were the user is right now
	 * @return null|void
	 */
	public function item( $id, $tab ) {
		?>
		<div id="mexp-item-wistia-<?php echo esc_attr( $tab ); ?>-{{ data.id }}" class="mexp-item-area mexp-item-wistia" data-id="{{ data.id }}">
			<div class="mexp-item-container clearfix">
				<div class="mexp-item-thumb">
					<img src="{{ data.thumbnail }}">
				</div>
				<div class="mexp-item-main">
					<div class="mexp-item-description">
						{{ data.content }}
					</div>
					<div class="mexp-item-date">
						{{ data.date }}
					</div>
				</div>
			</div>
		</div>
		<a href="#" id="mexp-check-{{ data.id }}" data-id="{{ data.id }}" class="check" title="<?php esc_attr_e( 'Deselect', 'mexp' ); ?>">
			<div class="media-modal-icon"></div>
		</a>
	<?php
	}

	public function thumbnail( $id ) {
		?>
	<?php
	}

	/**
	 * Template for the search form
	 *
	 * @param string $id the id of the view
	 * @param string $tab the tab were the user is right now
	 * @return null|void
	 */
	public function search( $id, $tab ) {
		?>
		<form action="#" class="mexp-toolbar-container clearfix tab-all">
			<input
					type="text"
					name="q"
					value="{{ data.params.q }}"
					class="mexp-input-text mexp-input-search"
					size="40"
					placeholder="<?php esc_attr_e( 'Search Wistia Account', 'mexp' ); ?>"
					>
			<input type="hidden" name="tab" value="all" />
			<input type="hidden" name="page_token" value="" id="page_token" class="all"/>
			<label for="type" style="display: none"><?php _e( 'Type:', 'mexp' ); ?></label>
			<select name="type">
				<option value="video"><?php esc_html_e( 'Videos', 'mexp' ); ?></option>
			</select>
			<input class="button button-large" type="submit" value="<?php esc_attr_e( 'Search', 'mexp') ?>">
			<input class="button button-large" type="submit" value="<?php esc_attr_e( 'Show all', 'mexp') ?>">
			<div class="spinner"></div>
		</form>
	<?php
	}

}
