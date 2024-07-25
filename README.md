# WordPress Blocks
This is a WordPress plugin which contains a few blocks to assist in starting out a new project. The blocks are built using the WordPress ACF and the block editor. This module also contains infrastructure to assist in the creation of template based blocks.

## Installation
Installation of this can be done using composer: `composer require creode/wordpress-blocks`

## Usage
This plugin once installed will be added to the mu-plugin folder so it is ready for it to be used in your project.

### Creating new blocks
In order to create new blocks, you can add a new class to your theme or plugin and extend the `CreodeBlocks\Block` class.

### Creating child blocks
Child blocks are defined within your block class inside the `child_blocks()` function. You can just need to return an array of new `CreodeBlocks\ChildBlock` instances from it.

## Roadmap

- [ ] Continue to expand the base offering of block classes
- [ ] Implement a command to create new blocks in your theme using `WP_CLI`
