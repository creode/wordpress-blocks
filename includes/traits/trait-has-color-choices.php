<?php
/**
 * Trait for providing colour choices based on configured theme colours.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use WP_Theme_JSON_Resolver;

/**
 * Trait for providing colour choices based on configured theme colours.
 */
trait Trait_Has_Color_Choices {

	/**
	 * Returns an ACF choces array of colors to be used within a radio field.
	 *
	 * @return array An ACF choces array of colors.
	 */
	protected function get_color_choices(): array {
		$this->add_preview_admin_css();
		$choices = array();
		$colors  = $this->get_theme_colors();

		foreach ( $colors as $color ) {
			$choices[ $color['slug'] ] = '<span class="color-choice-preview" style="background-color:' . $color['color'] . ';"></span>' . $color['name'];
		}

		return $choices;
	}

	/**
	 * Retrieves a theme color code by color slug.
	 *
	 * @param string $slug The slug of the color.
	 * @return string The color code or an empty string if color cannot be found.
	 */
	public function get_color_code_by_slug( string $slug ): string {
		$colors = $this->get_theme_colors();

		foreach ( $colors as $color ) {
			if ( $slug !== $color['slug'] ) {
				continue;
			}

			return $color['color'];
		}

		return '';
	}

	/**
	 * Adds CSS to the admin head to style the choice preview element.
	 * Will only add this once, regardless of how many times this function is called.
	 */
	private function add_preview_admin_css() {
		if ( apply_filters( 'colour_choice_preview_css_added', false ) ) {
			return;
		}

		add_action(
			'admin_head',
			function () {
				echo '
					<style>
						.color-choice-preview {
							display: inline-block;
							width: 12px;
							height: 12px;
							margin-right: 7px;
							border: solid 1px black;
						}
					</style>
				';
			}
		);

		add_filter(
			'colour_choice_preview_css_added',
			function () {
				return true;
			}
		);
	}

	/**
	 * Returns an array of theme color information.
	 *
	 * @return array Theme color information.
	 */
	private function get_theme_colors(): array {
		$theme = WP_Theme_JSON_Resolver::get_merged_data()->get_settings();
		return $theme['color']['palette']['theme'];
	}
}
