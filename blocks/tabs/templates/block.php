<?php
/**
 * Tabs block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Assign the block's name to a variable and remove the prefix.
 *
 * @var string The block's name.
 */
$block_name = str_replace( 'acf/', '', $block['name'] );

/**
 * Retrieve the Creode_Blocks\Block instance for this block type.
 *
 * @var Tabs_Block The instance for this block type.
 */
$creode_block = Helpers::get_block_by_name( $block_name );

/**
 * If the block should be hidden within the current context, do nothing.
 */
if ( $creode_block->should_hide() ) {
	return;
}

/**
 * Retrieve the active tab attribute.
 *
 * @var int The active tab index.
 */
$active_tab = Helpers::get_block_attribute( 'active_tab', $wp_block );
$active_tab = $active_tab ?? 0;

/**
 * Retrieve the patterns attribute.
 *
 * @var array The patterns array.
 */
$patterns = Helpers::get_block_attribute( 'patterns', $wp_block );
$patterns = $patterns ? explode( ',', $patterns ) : array();

/**
 * Assign the inner block template to a variable.
 *
 * @var array The inner block template.
 */
$inner_block_template = array(
	array(
		$block['name'] . '-tab',
	),
	array(
		$block['name'] . '-tab',
	),
	array(
		$block['name'] . '-tab',
	),
);
?>

<?php do_action( 'before_block_' . $block_name ); ?>

<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => $block_name . '__outer-wrapper' ) ); ?>>
<?php endif; ?>

<div
	class="tabs__wrapper <?php echo esc_attr( $creode_block->get_modifier_class_string( 'tabs__wrapper' ) ); ?>"
	data-active-tab="<?php echo esc_attr( $active_tab ); ?>"
>
	<div class="tabs__inner">
		<div class="tabs__main">
			<InnerBlocks
				allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
				template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
				orientation="horizontal"
				class="tabs__tabs"
			/>
		</div>
	</div>
</div>

<div class="tabs__patterns">
	<?php foreach ( $patterns as $index => $pattern ) : ?>
		<div
			class="tabs__pattern"
			data-index="<?php echo esc_attr( $index ); ?>"
			<?php if ( $index !== $active_tab ) : ?>
				hidden
				aria-hidden="true"
			<?php endif; ?>
		>
			<?php $creode_block->render_block_pattern( $pattern ); ?>
		</div>
	<?php endforeach; ?>
</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>

<?php do_action( 'after_block_' . $block_name ); ?>
