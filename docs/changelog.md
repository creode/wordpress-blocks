# Changelog

## 1.10.0
### SCSS File Generation
This change introduces the capability for blocks to be generated with an SCSS file. This file is added to the `assets` directory of the block. This starts to tie in nicely with the block functionality inside the new `creode/wordpress-theme` package as block SCSS can be added as part of the block generation process automatically and recompiled with default settings. This gives a nice productivity boost for developers.

If you would like to generate a block without an SCSS file, you can pass the `--no-scss` flag to the `make-block` command.

```bash
wp make-block --theme=creode --no-scss "My Block"
```

## 1.9.0
Introduces a new composer dependency for the block plugin. This dependency removes the requirement for a `loader.php` file in the mu-plugins directory and instead copies the mu-plugin.php file into the mu-plugins directory. This solves an issue where all mu-plugins were being loaded under one single mu-plugin.

The `loader.php` file should therefore be removed from your project.