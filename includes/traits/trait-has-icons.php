<?php
/**
 * Trait for allowing blocks to render icons from a standard set.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use Exception;

/**
 * Trait for allowing blocks to render icons from a standard set.
 */
trait Trait_Has_Icons {

	/**
	 * Returns a keyed array of icons where for each element the key is a unique reference to a particular icon and the value is a human readable icon name.
	 *
	 * @return array A keyed array of icons.
	 */
	private function icons(): array {
		return array();
	}

	/**
	 * Returns the human readable name of an icon.
	 *
	 * @param string $icon A unique reference to a particular icon.
	 * @return string The human readable name of an icon or an empty string if $icon is invalid.
	 */
	private function get_icon_name( $icon ): string {
		$all_icons = $this->icons();

		if ( empty( $all_icons[ $icon ] ) ) {
			return '';
		}

		return $all_icons[ $icon ];
	}

	/**
	 * Returns an ACF field schema for the icon field.
	 *
	 * @param string $key The ACF field key.
	 * @param bool   $include_none (optional) If the choice of no icon should be available. Defaults to false.
	 * @param string $name (optional) The ACF field name. Defaults to "icon".
	 * @return array The ACF field schema.
	 */
	protected function get_icon_field_schema( string $key, bool $include_none = false, string $name = 'icon' ): array {
		$choices = $this->icons();

		if ( $include_none ) {
			$choices = array_merge(
				array(
					'' => 'None',
				),
				$choices
			);
		}

		return array(
			'key'     => $key,
			'label'   => 'Icon',
			'name'    => $name,
			'type'    => 'select',
			'choices' => $choices,
		);
	}

	/**
	 * Returns icon file location information as an array. The array has the following properties: "path" and "url".
	 *
	 * @param string $icon The icon name.
	 * @throws Exception If the file cannot be found.
	 * @return array Icon file location information.
	 */
	private function get_icon_location( string $icon ): array {
		$possible_locations = array(
			array(
				'path' => get_stylesheet_directory() . '/images/icons/default/' . $icon . '.svg',
				'url'  => get_stylesheet_directory_uri() . '/images/icons/default/' . $icon . '.svg',
			),
			array(
				'path' => get_template_directory() . '/images/icons/default/' . $icon . '.svg',
				'url'  => get_template_directory_uri() . '/images/icons/default/' . $icon . '.svg',
			),
		);

		$possible_locations = apply_filters( 'creode_blocks_icon_locations', $possible_locations, $icon );

		foreach ( $possible_locations as $possible_location ) {
			if ( ! file_exists( $possible_location['path'] ) ) {
				continue;
			}

			return $possible_location;
		}

		throw new Exception(
			'Icon file cannot be found. Possible locations are: ' . esc_html(
				implode(
					' or ',
					array_unique(
						array_map(
							function ( array $possible_location ) {
								return $possible_location['url'];
							},
							$possible_locations
						)
					)
				)
			) . '.'
		);
	}

	/**
	 * Returns the HTML for an icon using an IMG element for rendering.
	 *
	 * @param string $base_class (optional) The base string that element classes are appended to.
	 * @param bool   $use_default (optional) Whether the default icon should be used if the icon field is empty.
	 * @param string $field_name (optional) The name of the field that contains the icon reference. Defaults to "icon".
	 * @return string The icon HTML. Empty string if icon is not set.
	 */
	public function get_icon_img( string $base_class = 'example-block', bool $use_default = true, string $field_name = 'icon' ): string {
		$icon = $this->get_field( $field_name );
		$icon = $use_default && empty( $icon ) ? array_key_first( $this->icons() ) : $icon;

		if ( empty( $icon ) ) {
			return '';
		}

		$location = $this->get_icon_location( $icon );

		return '<div class="' . $base_class . '__icon-img-wrapper ' . $base_class . '__icon-img-wrapper--' . $icon . '"><img src="' . $location['url'] . '" alt="' . $this->get_icon_name( $icon ) . '" class="' . $base_class . '__icon-image" /></div>';
	}

	/**
	 * Returns the HTML for an icon using an SVG element for rendering.
	 *
	 * @param string $base_class (optional) The base string that element classes are appended to.
	 * @param bool   $use_default (optional) Whether the default icon should be used if the icon field is empty.
	 * @param string $field_name (optional) The name of the field that contains the icon reference. Defaults to "icon".
	 * @return string The icon HTML. Empty string if icon is not set.
	 */
	public function get_icon_svg( string $base_class = 'example-block', bool $use_default = true, string $field_name = 'icon' ): string {
		$icon = $this->get_field( $field_name );
		$icon = $use_default && empty( $icon ) ? array_key_first( $this->icons() ) : $icon;

		if ( empty( $icon ) ) {
			return '';
		}

		$location = $this->get_icon_location( $icon );
		$svg      = wp_remote_get( $location['url'] );

		if (
			empty( $svg['response'] ) ||
			empty( $svg['response']['code'] ) ||
			empty( $svg['body'] )
		) {
			return '';
		}

		if ( 200 !== $svg['response']['code'] ) {
			return '';
		}

		return '<div class="' . $base_class . '__icon-svg-wrapper ' . $base_class . '__icon-svg-wrapper--' . $icon . '">' . $svg['body'] . '</div>';
	}
}
