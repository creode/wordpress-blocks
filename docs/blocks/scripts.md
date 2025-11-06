---
title: Block Scripts
editLink: false
---

# Block Scripts

Each block class can specify JavaScript files to be enqueued when the block is rendered on the front-end. This is done by overriding the `scripts()` method in your block class.

## The Scripts Method

The `scripts()` method should return an array of `Script` objects. Each `Script` object represents a JavaScript file that will be registered and enqueued for your block.

```php
/**
 * {@inheritdoc}
 */
protected function scripts(): array {
	return array(
		new Script( 'my-block-script', plugin_dir_url( __FILE__ ) . 'assets/my-block.js', array( 'jquery' ) ),
	);
}
```

## The Script Class

The `Script` class is used to define a JavaScript file to be enqueued. It accepts the following parameters in its constructor:

- **`$handle`** (string, required): A unique identifier for the script. This should be a unique string that won't conflict with other scripts.
- **`$src`** (string, required): The URL path to the JavaScript file. You can use functions like `plugin_dir_url( __FILE__ )` or `get_template_directory_uri()` to generate the correct path.
- **`$deps`** (array, optional): An array of script handles that this script depends on. Common dependencies include `'jquery'`, `'wp-api'`, etc. Defaults to an empty array.
- **`$ver`** (string, optional): The version number of the script. This is useful for cache busting. Defaults to `'1'`.

## How Scripts Are Enqueued

Scripts are automatically handled by the block system:

1. **Registration**: Scripts are registered during the `wp_enqueue_scripts` action hook. This happens early in the WordPress loading process, ensuring scripts are available when needed.

2. **Enqueuing**: Scripts are enqueued when the block is rendered on the front-end, using the `before_block_{block_name}` action hook. This ensures scripts are only loaded when the block is actually present on the page.

## Example Implementation

Here's a complete example of a block class that uses scripts:

```php
<?php
/**
 * My Custom Block block class.
 *
 * @package My Client's Brand
 */

use Creode_Blocks\Block;
use Creode_Blocks\Script;

/**
 * My Custom Block block class.
 */
class My_Custom_Block extends Block {

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'my-custom-block';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'My Custom Block';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return __DIR__ . '/templates/block.php';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function scripts(): array {
		return array(
			new Script(
				'my-custom-block-main',
				plugin_dir_url( __FILE__ ) . 'assets/main.js',
				array( 'jquery' ),
				'1.0.0'
			),
			new Script(
				'my-custom-block-utils',
				plugin_dir_url( __FILE__ ) . 'assets/utils.js',
				array(),
				'1.0.0'
			),
		);
	}
}
```

## Script Dependencies

When specifying dependencies, use the handles of other registered scripts. Common WordPress core script handles include:

- `'jquery'` - jQuery library
- `'wp-api'` - WordPress REST API client
- `'wp-i18n'` - Internationalization utilities
- `'wp-element'` - React and ReactDOM (for editor scripts)

You can also depend on scripts from other blocks or plugins by using their registered handles.

## Best Practices

1. **Unique Handles**: Always use unique script handles to avoid conflicts with other scripts. A good practice is to prefix handles with your block name (e.g., `'my-block-main'`).

2. **Version Numbers**: Use version numbers for cache busting, especially during development. Consider using a constant or theme version for production.

3. **Dependencies**: Always specify dependencies to ensure scripts load in the correct order.

4. **File Organization**: Keep your JavaScript files organized in an `assets` directory within your block folder.

5. **Conditional Loading**: Scripts are automatically only loaded when the block is rendered on the front-end, so you don't need to add conditional logic for this.

## Accessing Script Properties

The `Script` class provides read-only access to its properties via magic getters. While you typically won't need to access these directly, they are available if needed:

- `$script->handle` - The script handle
- `$script->src` - The script source URL
- `$script->deps` - The script dependencies array
- `$script->ver` - The script version

