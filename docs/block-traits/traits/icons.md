---
title: Icons Trait
editLink: false
---

# Icons Trait

The `Trait_Has_Icons` provides comprehensive icon management capabilities for blocks, including icon selection fields, rendering methods, and file location handling.

## Purpose

This trait is designed to:
- Add icon selection capabilities to blocks
- Provide standardized icon rendering methods
- Handle icon file location and validation
- Integrate with ACF fields for easy content editing
- Support both IMG and SVG rendering methods

## How It Works

The trait automatically:
1. Provides methods to define available icons
2. Generates ACF field schemas for icon selection
3. Handles icon file location resolution
4. Offers multiple rendering methods (IMG and SVG)
5. Integrates with theme icon directories

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Icons;
    
    // ... rest of block implementation
}
```

### Defining Available Icons

Override the `icons()` method to define which icons are available for your block:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Icons;
    
    /**
     * Returns a keyed array of icons where the key is a unique reference 
     * and the value is a human readable icon name.
     */
    private function icons(): array {
        return array(
            'arrow-right' => 'Arrow Right',
            'checkmark'   => 'Checkmark',
            'star'        => 'Star',
            'heart'       => 'Heart',
            'download'    => 'Download',
        );
    }
}
```

### Adding Icon Fields

Use the `get_icon_field_schema()` method to create ACF fields:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Icons;
    
    protected function fields(): array {
        return array(
            $this->get_icon_field_schema(
                'field_my_block_icon',
                true, // Include "None" option
                'icon' // Field name
            ),
        );
    }
    
    private function icons(): array {
        return array(
            'arrow-right' => 'Arrow Right',
            'checkmark'   => 'Checkmark',
            'star'        => 'Star',
        );
    }
}
```

## Available Methods

### `icons()`

Private method that returns a keyed array of available icons.

**Returns:** `array` - Keyed array where keys are icon references and values are human-readable names

**Example:**
```php
private function icons(): array {
    return array(
        'arrow-right' => 'Arrow Right',
        'checkmark'   => 'Checkmark',
    );
}
```

### `get_icon_field_schema( string $key, bool $include_none = false, string $name = 'icon' )`

Returns an ACF field schema for the icon field.

**Parameters:**
- `$key` (string) - The ACF field key
- `$include_none` (bool) - Whether to include a "None" option. Defaults to `false`
- `$name` (string) - The ACF field name. Defaults to `"icon"`

**Returns:** `array` - The ACF field schema

**Example:**
```php
$field = $this->get_icon_field_schema(
    'field_my_block_icon',
    true,  // Include "None" option
    'icon' // Field name
);
```

### `get_icon_img( string $base_class = 'example-block', bool $use_default = true, string $field_name = 'icon' )`

Returns HTML for an icon using an IMG element.

**Parameters:**
- `$base_class` (string) - Base string for element classes. Defaults to `'example-block'`
- `$use_default` (bool) - Whether to use the default icon if the field is empty. Defaults to `true`
- `$field_name` (string) - Name of the field containing the icon reference. Defaults to `"icon"`

**Returns:** `string` - The icon HTML or empty string if icon is not set

**Example:**
```php
$icon_html = $this->get_icon_img( 'my-block', true, 'icon' );
```

### `get_icon_svg( string $base_class = 'example-block', bool $use_default = true, string $field_name = 'icon' )`

Returns HTML for an icon using an SVG element.

**Parameters:**
- `$base_class` (string) - Base string for element classes. Defaults to `'example-block'`
- `$use_default` (bool) - Whether to use the default icon if the field is empty. Defaults to `true`
- `$field_name` (string) - Name of the field containing the icon reference. Defaults to `"icon"`

**Returns:** `string` - The icon HTML or empty string if icon is not set

**Example:**
```php
$icon_html = $this->get_icon_svg( 'my-block', true, 'icon' );
```

### `get_icon_name( string $icon )`

Returns the human-readable name of an icon.

**Parameters:**
- `$icon` (string) - Unique reference to a particular icon

**Returns:** `string` - Human-readable icon name or empty string if invalid

**Example:**
```php
$icon_name = $this->get_icon_name( 'arrow-right' ); // Returns: "Arrow Right"
```

### `get_color_code_by_slug( string $slug )`

Returns a theme color code by color slug.

**Parameters:**
- `$slug` (string) - The slug of the color

**Returns:** `string` - The color code or empty string if color cannot be found

**Example:**
```php
$color_code = $this->get_color_code_by_slug( 'primary' ); // Returns: "#007cba"
```

## Icon File Locations

The trait automatically searches for icon files in the following locations:

1. **Child Theme:** `{child-theme}/images/icons/default/{icon-name}.svg`
2. **Parent Theme:** `{parent-theme}/images/icons/default/{icon-name}.svg`

### Custom Icon Locations

You can customize icon locations using the `creode_blocks_icon_locations` filter:

```php
<?php
add_filter( 'creode_blocks_icon_locations', function( $locations, $icon ) {
    // Add custom icon directory
    $locations[] = array(
        'path' => get_stylesheet_directory() . '/custom-icons/' . $icon . '.svg',
        'url'  => get_stylesheet_directory_uri() . '/custom-icons/' . $icon . '.svg',
    );
    
    return $locations;
}, 10, 2 );
```

## Template Usage

### Basic Icon Rendering

```php
<?php
// Render icon as IMG element
echo $this->get_icon_img( 'my-block' );

// Render icon as SVG element
echo $this->get_icon_svg( 'my-block' );
```

### With Conditional Logic

```php
<?php
$icon = $this->get_field( 'icon' );

if ( ! empty( $icon ) ) {
    echo $this->get_icon_img( 'my-block', false );
}
```

### Custom Field Names

```php
<?php
// Use a custom field name
echo $this->get_icon_img( 'my-block', true, 'custom_icon_field' );
```

## CSS Integration

### Basic Icon Styling

```scss
.my-block__icon-img-wrapper {
    display: inline-block;
    vertical-align: middle;
    
    &--arrow-right {
        // Specific styles for arrow-right icon
    }
    
    &--checkmark {
        // Specific styles for checkmark icon
    }
}

.my-block__icon-image {
    width: 24px;
    height: 24px;
    display: block;
}
```

### SVG Icon Styling

```scss
.my-block__icon-svg-wrapper {
    display: inline-block;
    vertical-align: middle;
    
    svg {
        width: 24px;
        height: 24px;
        fill: currentColor;
    }
    
    &--arrow-right {
        svg {
            transform: rotate(0deg);
        }
    }
}
```

## Use Cases

### Feature Lists

```php
<?php
class Feature_List_Block extends Block {
    use Trait_Has_Icons;
    
    private function icons(): array {
        return array(
            'checkmark' => 'Checkmark',
            'star'      => 'Star',
            'heart'     => 'Heart',
        );
    }
}
```

### Call-to-Action Buttons

```php
<?php
class CTA_Button_Block extends Block {
    use Trait_Has_Icons;
    
    private function icons(): array {
        return array(
            'arrow-right' => 'Arrow Right',
            'download'    => 'Download',
            'play'        => 'Play',
        );
    }
}
```

### Navigation Elements

```php
<?php
class Navigation_Block extends Block {
    use Trait_Has_Icons;
    
    private function icons(): array {
        return array(
            'menu'        => 'Menu',
            'search'      => 'Search',
            'user'        => 'User',
            'shopping-cart' => 'Shopping Cart',
        );
    }
}
```

## Error Handling

The trait includes comprehensive error handling:

- **File not found:** Throws an exception with possible locations
- **Invalid icon reference:** Returns empty string for invalid icons
- **Missing field:** Gracefully handles empty icon fields
- **Network errors:** Handles SVG loading failures gracefully

## Best Practices

1. **Use descriptive names** - Choose clear, human-readable icon names
2. **Organize icons logically** - Group related icons together
3. **Provide fallbacks** - Always include a default icon option
4. **Optimize SVG files** - Ensure SVG files are optimized for web use
5. **Test icon rendering** - Verify icons display correctly in all contexts
6. **Consider accessibility** - Provide meaningful alt text for icon images

## Common Icon Patterns

- **Navigation:** `menu`, `close`, `arrow-left`, `arrow-right`
- **Actions:** `download`, `upload`, `play`, `pause`, `stop`
- **Status:** `checkmark`, `cross`, `warning`, `info`
- **Social:** `facebook`, `twitter`, `instagram`, `linkedin`
- **Content:** `image`, `video`, `document`, `link`
