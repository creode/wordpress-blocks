# WordPress Blocks
This is a WordPress plugin which contains a few blocks to assist in starting out a new project. The blocks are built using the WordPress ACF and the block editor. This module also contains infrastructure to assist in the creation of template based blocks.

## Installation
Installation of this can be done using composer: `composer require creode/wordpress-blocks`

## Usage
This plugin once installed will be added to the mu-plugin folder so it is ready for it to be used in your project.

### Creating new blocks
In order to create new blocks, you can add a new class to your theme or plugin and extend the `Creode_Blocks\Block` class.

If you are utilising WP_CLI for your project, you can use the following command to create a new block class:

```bash
wp make-block "Creode Footer" --theme="creode"
```

This will create a newly configured block class and template file within your theme, inside the `blocks` directory. The theme argument is optional and will default to the current theme.

It will also output a couple of lines that can be copy and pasted into your `functions.php` file to include the block class and get started quickly.

### Creating child blocks
Child blocks are defined within your block class inside the `child_blocks()` function. You can just need to return an array of new `Creode_Blocks\Child_Block` instances from it.

## Roadmap

- [ ] Continue to expand the base offering of block classes
- [x] Implement a command to create new blocks in your theme using `WP_CLI`
