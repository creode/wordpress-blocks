<?php
/**
 * Search and Filter block definition.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use Search_Filter\Queries\Settings as Search_Filter_Query_Settings;
use Search_Filter\Queries as Search_Filter_Queries;
use Search_Filter\Queries\Query as Search_Filter_Query;
use WP_Query;

/**
 * Search and Filter block definition.
 */
class Search_And_Filter_Block extends Block {

	use Trait_Has_Modifier_Classes;
	use Trait_Block_Pattern_Options;

	/**
	 * Singleton instance of this class.
	 *
	 * @var Block
	 */
	protected static $instance = null;

	/**
	 * {@inheritDoc}
	 */
	protected function setup(): bool {
		if ( ! class_exists( Search_Filter_Query_Settings::class ) ) {
			return false;
		}
		if ( ! class_exists( Search_Filter_Queries::class ) ) {
			return false;
		}
		if ( ! class_exists( Search_Filter_Query::class ) ) {
			return false;
		}

		$this->add_pattern_query_setting();
		$this->disable_pagination_query_setting();
		$this->ensure_results_template_exists();

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	protected function modifier_classes(): array {
		return array();
	}

	/**
	 * Adds a setting to Search and Filter queries to allow a render pattern to be selected for displaying a result.
	 */
	protected function add_pattern_query_setting() {
		$choices = array();

		foreach ( $this->get_block_pattern_choices() as $value => $label ) {
			array_push(
				$choices,
				array(
					'value' => $value,
					'label' => $label,
				)
			);
		}

		add_action(
			'search-filter/settings/init',
			function () use ( $choices ) {
				Search_Filter_Query_Settings::add_setting(
					array(
						'name'      => 'resultRenderPattern',
						'label'     => 'Result render pattern',
						'group'     => 'integration',
						'type'      => 'string',
						'inputType' => 'Select',
						'options'   => $choices,
						'dependsOn' => array(
							'relation' => 'AND',
							'rules'    => array(
								array(
									'option'  => 'integrationType',
									'compare' => '=',
									'value'   => 'single',
								),
								array(
									'option'  => 'singleIntegration',
									'compare' => '=',
									'value'   => 'results_shortcode',
								),
							),
						),
					),
					array(
						'position' => array(
							'placement' => 'after',
							'setting'   => 'resultsShortcode',
						),
					)
				);
			}
		);
	}

	/**
	 * Adds a setting to Search and Filter queries to disable pagination.
	 */
	protected function disable_pagination_query_setting() {
		add_action(
			'search-filter/settings/init',
			function () {
				Search_Filter_Query_Settings::add_setting(
					array(
						'name'      => 'disablePagination',
						'label'     => 'Disable pagination',
						'group'     => 'integration',
						'type'      => 'string',
						'inputType' => 'Toggle',
						'dependsOn' => array(
							'relation' => 'AND',
							'rules'    => array(
								array(
									'option'  => 'integrationType',
									'compare' => '=',
									'value'   => 'single',
								),
								array(
									'option'  => 'singleIntegration',
									'compare' => '=',
									'value'   => 'results_shortcode',
								),
							),
						),
					),
					array(
						'position' => array(
							'placement' => 'after',
							'setting'   => 'resultRenderPattern',
						),
					)
				);
			}
		);
	}

	/**
	 * Ensures that a results template exists in the active theme.
	 */
	protected function ensure_results_template_exists() {
		global $wp_filesystem;

		if ( ! isset( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( $wp_filesystem->exists( get_stylesheet_directory() . '/search-filter/results.php' ) ) {
			return;
		}

		if ( ! $wp_filesystem->exists( get_stylesheet_directory() . '/search-filter' ) ) {
			$wp_filesystem->mkdir( get_stylesheet_directory() . '/search-filter' );
		}

		$wp_filesystem->put_contents( get_stylesheet_directory() . '/search-filter/results.php', $wp_filesystem->get_contents( plugin_dir_path( __FILE__ ) . 'templates/defaults/results.php' ) );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function name(): string {
		return 'search-and-filter';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function label(): string {
		return 'Search and Filter';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function fields(): array {
		return array();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function template(): string {
		return plugin_dir_path( __FILE__ ) . 'templates/block.php';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function child_blocks(): array {
		$query_choices = $this->get_query_choices();

		return array(
			new Child_Block(
				'form',
				'Search and Filter Form',
				array(),
				plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form.php',
				array(
					new Child_Block(
						'search',
						'Search and Filter Search',
						array(),
						plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form/search.php',
					),
					new Child_Block(
						'choice',
						'Search and Filter Choice',
						array(),
						plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form/choice.php',
					),
					new Child_Block(
						'range',
						'Search and Filter Range',
						array(),
						plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form/range.php',
					),
					new Child_Block(
						'advanced',
						'Search and Filter Advanced',
						array(),
						plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form/advanced.php',
					),
					new Child_Block(
						'reusable',
						'Search and Filter Reusable',
						array(),
						plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form/reusable.php',
					),
					new Child_Block(
						'control',
						'Search and Filter Control',
						array(),
						plugin_dir_path( __FILE__ ) . 'templates/child-blocks/form/control.php',
					),
				)
			),
			new Child_Block(
				'results',
				'Search and Filter Results',
				array(
					array(
						'key'           => 'field_search_and_filter_results_query_id',
						'label'         => 'Query',
						'name'          => 'query_id',
						'type'          => 'select',
						'default_value' => array_key_first( $query_choices ),
						'choices'       => $query_choices,
					),
				),
				plugin_dir_path( __FILE__ ) . 'templates/child-blocks/results.php'
			),
		);
	}

	/**
	 * Retrieves an array of Search and Filter queries intended for use as choices for an ACF select field.
	 *
	 * @return array An array of Search and Filter query choices.
	 */
	protected function get_query_choices() {
		$choices = array();

		$queries = Search_Filter_Queries::find(
			array(
				'status' => 'enabled',
				'number' => 0,
			)
		);

		foreach ( $queries as $query ) {
			if ( Search_Filter_Query::class != get_class( $query ) ) {
				continue;
			}
			$choices[ $query->get_id() ] = $query->get_name();
		}

		return $choices;
	}

	/**
	 * Renders the results list.
	 *
	 * @param array    $args Array of arguments provided by Search and Filter to the results template.
	 * @param WP_Query $query The WP_Query object privided by Search and Filter to the results template.
	 */
	public function render_results_list( array $args, WP_Query $query ) {
		if ( empty( $args['search_filter_query_id'] ) ) {
			return;
		}

		$search_filter_query = Search_Filter_Query::find( array( 'id' => $args['search_filter_query_id'] ) );

		if ( 'WP_Error' === get_class( $search_filter_query ) ) {
			echo '<p>' . esc_html( $search_filter_query->get_error_message() ) . '</p>';
			return;
		}

		$pattern = $search_filter_query->get_attribute( 'resultRenderPattern' );

		if ( empty( $pattern ) ) {
			echo '<p>Please choose a result render pattern for this search and filter query.</p>';
			return;
		}

		$pagination_type = $search_filter_query->get_attribute( 'resultsPaginationType' );
		$pagination_type = ! empty( $pagination_type ) ? $pagination_type : 'default';

		$disable_pagination = $search_filter_query->get_attribute( 'disablePagination' ) === 'yes' ? true : false;

		include apply_filters( 'creode_blocks_search_and_filter_results_list_template', plugin_dir_path( __FILE__ ) . 'templates/results-list.php' );
	}
}
