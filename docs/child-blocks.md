---
title: Child Blocks
editLink: false
---

# Child Blocks

So far we have covered everything involved with basic block development. However blocks often require complex markup structures with multiple InnerBlocks elements. Using child blocks allows for this.

## What are child blocks

These are blocks that are only allowed to be added to the InnerBlocks element of one particular block, it's parent. These will not appear within the WordPress block inserter unless their parent block is selected. Each child block can also contain an InnerBlocks element as per their parent, therefore they can have their own child blocks. This means that a complex ancestral hierarchy can be defined for each block. Child blocks can be included as part of an InnerBlocks element's template attribute array and template locking can prevent child blocks from being removed from their ancestral hierarchy.

## Why are child blocks needed

Unfortunately WordPress cannot support multiple InnerBlocks elements for a single block. To understand this, let's take a look at the markup structure that will be added to a post's content field when the previously mentioned "My New Block" block is added to a post.

```html
<!-- wp:acf/my-new-block-block {"name":"acf/my-new-block-block","data":{},"mode":"preview"} -->
    <!-- wp:heading -->
        <h2 class="wp-block-heading">My New Block</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph -->
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.</p>
    <!-- /wp:paragraph -->
<!-- /wp:acf/my-new-block-block -->
```

WordPress uses an html structure with comment tags to define it's blocks. In the example above the following line defines the start of a block:

```html
<!-- wp:acf/my-new-block-block {"name":"acf/my-new-block-block","data":{},"mode":"preview"} -->
```

This line defines the end of a block:

```html
<!-- /wp:acf/my-new-block-block -->
```

Everything in between these two lines defines the content of the InnerBlocks element therefore there would be nowhere to define the content of another InnerBlocks element.

## How child blocks solve this problem

If multiple InnerBlocks elements are needed, multiple child blocks can be defined each containing an InnerBlocks element. The allowedBlocks attribute for the top-level block's InnerBlocks element could then be provided an empty array. This means that no other blocks other than child blocks can be added. The child blocks could then be included in the template attribute array and the InnerBlocks element could be template locked.
