---
title: Color Choices Trait
editLink: false
---

# Color Choices Trait

The `Trait_Has_Color_Choices` integrates blocks with WordPress theme color palettes, providing content editors with access to predefined theme colors through an intuitive ACF field interface.

## Purpose

This trait is designed to:
- Integrate blocks with WordPress theme color systems
- Provide consistent color choices across the site
- Automatically generate ACF color selection fields
- Display visual color previews in the admin interface
- Maintain color consistency when theme colors change

## How It Works

The trait automatically:
1. Retrieves colors from the active theme's `theme.json` file
2. Generates ACF choice fields with visual color previews
3. Provides methods to retrieve color codes by slug
4. Adds admin CSS for color preview styling
5. Integrates with WordPress block editor color systems

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Color_Choices;
    
    // ... rest of block implementation
}
```

### Adding Color Fields

Use the `get_color_choices()` method to create ACF fields:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Color_Choices;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_my_block_background_color',
                'name'  => 'background_color',
                'label' => 'Background Color',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
```

### Retrieving Color Values

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Color_Choices;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_my_block_text_color',
                'name'  => 'text_color',
                'label' => 'Text Color',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
```

## Available Methods

### `get_color_choices()`

Returns an ACF choices array of colors to be used within a radio field.

**Returns:** `array` - An ACF choices array with color slugs as keys and formatted labels as values

**Example:**
```php
$choices = $this->get_color_choices();
// Returns: array(
//     'primary' => '<span class="color-choice-preview" style="background-color:#007cba;"></span>Primary',
//     'secondary' => '<span class="color-choice-preview" style="background-color:#f0f0f0;"></span>Secondary',
// )
```

### `get_color_code_by_slug( string $slug )`

Retrieves a theme color code by color slug.

**Parameters:**
- `$slug` (string) - The slug of the color

**Returns:** `string` - The color code or an empty string if color cannot be found

**Example:**
```php
$color_code = $this->get_color_code_by_slug( 'primary' ); // Returns: "#007cba"
```

## Theme Color Configuration

The trait automatically reads colors from your theme's `theme.json` file. Here's an example configuration:

```json
{
    "version": 2,
    "settings": {
        "color": {
            "palette": {
                "theme": [
                    {
                        "slug": "primary",
                        "color": "#007cba",
                        "name": "Primary"
                    },
                    {
                        "slug": "secondary",
                        "color": "#f0f0f0",
                        "name": "Secondary"
                    },
                    {
                        "slug": "accent",
                        "color": "#ff6b35",
                        "name": "Accent"
                    }
                ]
            }
        }
    }
}
```

## Template Usage

### Basic Color Application

```php
<?php
$background_color = $this->get_field( 'background_color' );
$text_color = $this->get_field( 'text_color' );

if ( ! empty( $background_color ) ) {
    $bg_color_code = $this->get_color_code_by_slug( $background_color );
}
?>

<div class="my-block" 
     style="<?php echo ! empty( $bg_color_code ) ? 'background-color: ' . esc_attr( $bg_color_code ) . ';' : ''; ?>">
    <h2 style="<?php echo ! empty( $text_color ) ? 'color: ' . esc_attr( $this->get_color_code_by_slug( $text_color ) ) . ';' : ''; ?>">
        Block Title
    </h2>
</div>
```

### With CSS Classes

```php
<?php
$background_color = $this->get_field( 'background_color' );
$text_color = $this->get_field( 'text_color' );
?>

<div class="my-block my-block--bg-<?php echo esc_attr( $background_color ); ?> my-block--text-<?php echo esc_attr( $text_color ); ?>">
    <!-- Block content -->
</div>
```

### Dynamic Color Styling

```php
<?php
$background_color = $this->get_field( 'background_color' );
$text_color = $this->get_field( 'text_color' );

$inline_styles = array();

if ( ! empty( $background_color ) ) {
    $inline_styles[] = 'background-color: ' . esc_attr( $this->get_color_code_by_slug( $background_color ) );
}

if ( ! empty( $text_color ) ) {
    $inline_styles[] = 'color: ' . esc_attr( $this->get_color_code_by_slug( $text_color ) );
}

$style_attribute = ! empty( $inline_styles ) ? ' style="' . implode( '; ', $inline_styles ) . '"' : '';
?>

<div class="my-block"<?php echo $style_attribute; ?>>
    <!-- Block content -->
</div>
```

## CSS Integration

### Basic Color Classes

```scss
.my-block {
    // Base styles
    
    &--bg-primary {
        background-color: var(--wp--preset--color--primary);
    }
    
    &--bg-secondary {
        background-color: var(--wp--preset--color--secondary);
    }
    
    &--text-primary {
        color: var(--wp--preset--color--primary);
    }
    
    &--text-secondary {
        color: var(--wp--preset--color--secondary);
    }
}
```

### Using CSS Custom Properties

```scss
.my-block {
    &--bg-primary {
        background-color: var(--wp--preset--color--primary);
    }
    
    &--bg-secondary {
        background-color: var(--wp--preset--color--secondary);
    }
    
    &--bg-accent {
        background-color: var(--wp--preset--color--accent);
    }
}
```

### Responsive Color Variations

```scss
.my-block {
    &--bg-primary {
        background-color: var(--wp--preset--color--primary);
        
        @media (max-width: 768px) {
            background-color: var(--wp--preset--color--secondary);
        }
    }
}
```

## Use Cases

### Content Blocks with Color Themes

```php
<?php
class Content_Block extends Block {
    use Trait_Has_Color_Choices;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_content_block_theme',
                'name'  => 'theme',
                'label' => 'Color Theme',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
```

### Call-to-Action Buttons

```php
<?php
class CTA_Button_Block extends Block {
    use Trait_Has_Color_Choices;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_cta_button_background',
                'name'  => 'background_color',
                'label' => 'Button Background',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
            array(
                'key'   => 'field_cta_button_text',
                'name'  => 'text_color',
                'label' => 'Button Text Color',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
```

### Section Backgrounds

```php
<?php
class Section_Block extends Block {
    use Trait_Has_Color_Choices;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_section_background',
                'name'  => 'background_color',
                'label' => 'Section Background',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
```

## Admin Interface

The trait automatically adds CSS to the admin head to style the color choice preview elements:

```css
.color-choice-preview {
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 7px;
    border: solid 1px black;
}
```

This creates small color squares next to each color option in the ACF field, making it easy for content editors to see the actual colors.

## Error Handling

The trait gracefully handles various scenarios:

- **No theme colors:** Returns empty choices array
- **Invalid color slug:** Returns empty string for color code
- **Missing theme.json:** Falls back gracefully
- **Color not found:** Returns empty string

## Best Practices

1. **Use semantic names** - Choose color names that describe their purpose (e.g., "primary", "secondary", "accent")
2. **Limit color options** - Don't overwhelm editors with too many color choices
3. **Consider accessibility** - Ensure sufficient contrast between text and background colors
4. **Test color combinations** - Verify that all color combinations work well together
5. **Document color usage** - Let editors know when and how to use different colors
6. **Use CSS custom properties** - Leverage WordPress CSS custom properties for consistent theming

## Common Color Patterns

- **Primary/Secondary:** Main brand colors
- **Accent:** Highlight and call-to-action colors
- **Neutral:** Text and background colors
- **Semantic:** Success, warning, error colors
- **Brand:** Company-specific color schemes
