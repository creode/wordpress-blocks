---
title: Post Listing Block
editLink: false
---

# Post Listing Block

## Description

The Post Listing Block is a powerful, flexible block for displaying lists of posts with advanced customization options. It integrates seamlessly with WordPress Query blocks and provides extensive control over sorting, layout, and content display through a sophisticated child block architecture.

## Features

- **Query Block Integration** - Works with core WordPress Query blocks
- **Custom Sorting** - Override sort order with metafield-based sorting
- **Nested Child Blocks** - Three levels of child blocks for complex layouts
- **Dynamic Context Support** - Pass custom context data through nested blocks
- **Extensible Templates** - Filterable inner block and section templates
- **Flexible Structure** - Customizable sections for posts and pagination

## Use Cases

### Basic Post Listing
Extend the post listing with custom display options.

```php
class My_Post_Listing_Block extends \Creode_Blocks\Post_Listing_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        // Add custom layout field
        $fields[] = array(
            'key' => 'field_listing_layout',
            'name' => 'listing_layout',
            'label' => 'Layout Style',
            'type' => 'select',
            'choices' => array(
                'grid' => 'Grid',
                'list' => 'List',
                'masonry' => 'Masonry',
            ),
        );
        
        return $fields;
    }
}
```

### Post Listing with Metafield Sorting
Enable sorting by custom post meta fields.

```php
class Event_Listing_Block extends \Creode_Blocks\Post_Listing_Block {
    protected function get_metafield_sort_options(): array {
        return array(
            'event_date' => 'Event Date',
            'event_location' => 'Event Location',
            'event_priority' => 'Priority',
        );
    }
}
```

### Understanding Block Structure

::: warning Important
The Post Listing Block is inserted with a specific nested structure that includes a WordPress Query block and multiple child blocks. This structure ensures consistent behavior and proper integration with WordPress's query system.

**Block Structure:**
- The block contains a `core/query` block
- Inside is an `acf/post-listing-inner` block
- Which contains `acf/post-listing-inner-sections` blocks
- Which contain `acf/post-listing-inner-sections-section` blocks
- These sections hold the actual content (post template, pagination, etc.)

**Modifying Structure:**
While it is technically possible to modify the inner block template structure using methods like `get_inner_block_template()` and `get_section_structure_block_template()`, this should be done with extreme caution. Incorrect modifications can break the block's functionality.

**Recommended Approach:**
Instead of modifying the block structure, use the block editor to:
- Add or remove core blocks within the sections
- Customize the post template
- Add filters or additional content
- Use the `get_allowed_inner_blocks()` method to control which blocks can be added

Only modify the block structure if you have a thorough understanding of the underlying architecture.
:::

### Custom Query Modification
Modify query arguments based on dynamic context or custom logic.

```php
class Filtered_Post_Listing_Block extends \Creode_Blocks\Post_Listing_Block {
    protected function modify_query_args_based_on_dynamic_context(
        $query_args, 
        $dynamic_context
    ): array {
        // Call parent first
        $query_args = parent::modify_query_args_based_on_dynamic_context(
            $query_args,
            $dynamic_context
        );
        
        // Add custom filtering
        if (isset($dynamic_context['category_filter'])) {
            $query_args['category_name'] = $dynamic_context['category_filter'];
        }
        
        if (isset($dynamic_context['exclude_posts'])) {
            $query_args['post__not_in'] = $dynamic_context['exclude_posts'];
        }
        
        return $query_args;
    }
}
```

## Block Structure

The Post Listing Block uses a three-level child block structure:

```
Post Listing Block
└── Query Block (core/query)
    └── Post Listing - Inner (acf/post-listing-inner)
        └── Post Listing - Sections (acf/post-listing-inner-sections)
            └── Post Listing - Section (acf/post-listing-inner-sections-section)
                └── Core blocks (post-template, pagination, etc.)
```

## Child Blocks

| Level | Block Name | Purpose |
|-------|-----------|---------|
| 1 | Post Listing - Inner | Main container for all content |
| 2 | Post Listing - Sections | Groups related sections together |
| 3 | Post Listing - Section | Individual section for specific content |

## Sorting Options

### Default Sorting
Posts follow the Query block's sort settings.

### Metafield Sorting
Override with custom field sorting:

```php
protected function get_metafield_sort_options(): array {
    return array(
        'price' => 'Price',
        'rating' => 'Rating',
        'date_published' => 'Publication Date',
    );
}
```

Users can then select:
- Which metafield to sort by
- Sort direction (ASC/DESC)

## Extending

### Custom Allowed Inner Blocks

```php
public function get_allowed_inner_blocks(): array {
    return array_merge(
        parent::get_allowed_inner_blocks(),
        array(
            'core/buttons',
            'core/separator',
            'acf/custom-post-card',
        )
    );
}
```

### Filter Hooks

The block provides several filters for customization:

```php
// Modify the entire inner block template
add_filter('creode_blocks_post_listing_inner_block_template', function($template) {
    // Modify template structure
    return $template;
});

// Modify section structure
add_filter('creode_blocks_post_listing_section_structure_template', function($template) {
    // Modify section layout
    return $template;
});

// Modify allowed inner blocks
add_filter('creode_blocks_post_listing_allowed_inner_blocks', function($blocks) {
    $blocks[] = 'acf/my-custom-block';
    return $blocks;
});
```

## Integration with Integrated Pattern

The Post Listing Block works seamlessly with the Integrated Pattern utility block:

```php
array(
    'core/post-template',
    array(),
    array(
        array('acf/integrated-pattern'), // Render pattern for each post
    ),
),
```

## Related Blocks

- [Integrated Pattern Block](/utility-blocks/integrated-pattern) - For rendering patterns within post templates

