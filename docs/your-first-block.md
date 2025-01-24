---
title: Your first block
---
# Your first block

This plugin does include a WordPress CLI command to generate a new block definition within a theme. However it is very important to understand the fundamentals. It may be beneficial to create a practice block manually before using the CLI command for blocks intended for production.

## The key concept

Each block is defined as a new PHP class, each block class should be an extension of the Creode_Blocks\Block abstract class. Each block class must contain functions for returning information about the block, e.g. the block label.

## The block class

Each block class must have the following required functions:
 - "name" (must return a meaningful block name, this should be a lowercase a hyphen separated string)
 - "label" (must return text to label the block within the admin UI)
 - "template" (must return a complete path to a php file that will be used to render the block)

Each block should also contain a protected static $instance property. This will be used to store a single instance of the class. This instance can be retrieved globally using a helper function.