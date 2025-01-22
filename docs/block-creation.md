---
title: Creation
editLink: false
---
# Creation
The creation of a new block is very simple and can be done in a few steps. The plugin is built to be simple to use and easy to get started with.

There is a very useful script which has been written in WP-CLI which can be used to create a new block. This script will create all the necessary files and folders for a new block within the currently active theme by default. The script can be run with the following command:

```bash
wp make-block "My New Block"
```

With "My New Block" being the name of the block you would like to create. This will then add a new block to the blocks folder with the theme. The block will be created with a basic block structure and will be ready to be edited and used.

The created structure looks like this:

```
blocks
└── my-new-block
    ├── templates
    │   └── block.php
    └── class-my-new-block.php
```