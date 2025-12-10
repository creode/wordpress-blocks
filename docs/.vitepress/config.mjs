import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "WordPress Blocks Plugin",
  description: "Serves as developer Documentation for the WordPress Blocks Plugin",
  head: [['link', { rel: 'icon', href: '/favicon.png' }]],
	outDir: '../build/docs',
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'API Documentation', link: 'https://blocks.creode.dev/api/index.html' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        collapsed: false,
        items: [
          { text: 'What Is It?', link: '/what-is-it' },
          { text: 'Quick Start', link: '/quick-start' },
          { text: 'Upgrading', link: '/upgrading', items: [
            { text: 'Introduction', link: '/upgrading/index.md' },
            { text: '2.x to 3.x', link: '/upgrading/2.x-3.x.md' },
            { text: '1.x to 2.x', link: '/upgrading/1.x-2.x.md' },
            { text: '0.x to 1.x', link: '/upgrading/0.x-1.x.md' },
            { text: 'Rector', link: '/upgrading/rector.md' },
          ]},
          { text: 'Changelog', link: '/changelog' },
        ]
      },
      {
        text: 'Blocks',
        items: [
          { text: 'The Block Class', link: '/blocks/the-block-class' },
          { text: 'Creation', link: '/blocks/creation' },
          { text: 'Order', link: '/blocks/order' },
          { text: 'Categorization', link: '/blocks/categorization' },
          { text: 'Fields', link: '/blocks/fields' },
          { text: 'Supports', link: '/blocks/supports' },
          { text: 'Templates', link: '/blocks/template' },
          { text: 'Block Scripts', link: '/blocks/scripts' },
          { text: 'Child Blocks', link: 'blocks/child-blocks' }
        ]
      },
      {
        text: 'Block Traits',
        collapsed: false,
        items: [
          { text: 'Introduction', link: '/block-traits/introduction' },
          { text: 'Auto Initialization', link: '/block-traits/auto-initialization' },
          { text: 'Traits Overview', link: '/block-traits/traits-overview' },
          {
            text: 'Available Traits',
            items: [
                { text: 'Unique ID', link: '/block-traits/traits/unique-id' },
                { text: 'Modifier Classes', link: '/block-traits/traits/modifier-classes' },
                { text: 'CSS Variables', link: '/block-traits/traits/css-variables' },
                { text: 'Reduce Bottom Space', link: '/block-traits/traits/reduce-bottom-spacing' },
                { text: 'Icons', link: '/block-traits/traits/icons' },
                { text: 'Color Choices', link: '/block-traits/traits/color-choices' },
                { text: 'Block Patterns', link: '/block-traits/traits/block-patterns' },
                { text: 'Menu Integration', link: '/block-traits/traits/menu-rendering' },
                { text: 'Editor Restriction', link: '/block-traits/traits/editor-restriction' },
                { text: 'Post Type Restriction', link: '/block-traits/traits/post-type-restriction' },
            ]
          }
        ]
      },
      {
        text: 'Helpers',
        collapsed: false,
        items: [
          { text: 'Introduction', link: '/helpers/index' },
          { text: 'set_default_block_category', link: '/helpers/set_default_block_category' },
          { text: 'get_block_by_name', link: '/helpers/get_block_by_name' },
          { text: 'render_blocks', link: '/helpers/render_blocks' },
          { text: 'render_blocks_in_post_context', link: '/helpers/render_blocks_in_post_context' },
          { text: 'render_inner_blocks_in_post_context', link: '/helpers/render_inner_blocks_in_post_context' },
          { text: 'render_blocks_with_dynamic_context', link: '/helpers/render_blocks_with_dynamic_context' },
          { text: 'add_dynamic_context_to_blocks', link: '/helpers/add_dynamic_context_to_blocks' },
          { text: 'get_child_block_by_path', link: '/helpers/get_child_block_by_path' },
          { text: 'replace_child_block_by_path', link: '/helpers/replace_child_block_by_path' },
          { text: 'set_acf_block_mode', link: '/helpers/set_acf_block_mode' },
        ]
      },
      {
        text: 'Block Library',
        collapsed: false,
        items: [
          { text: 'Introduction', link: '/block-library/index' },
          { text: 'Site Header', link: '/block-library/site-header' },
          { text: 'Desktop Menu', link: '/block-library/desktop-menu' },
          { text: 'Mobile Menu', link: '/block-library/mobile-menu' },
          { text: 'Post Listing', link: '/block-library/post-listing' }
        ]
      },
      {
        text: 'Utility Blocks',
        collapsed: false,
        items: [
          { text: 'Introduction', link: '/utility-blocks/index' },
          { text: 'Integrated Menu', link: '/utility-blocks/integrated-menu' },
          { text: 'Integrated Pattern', link: '/utility-blocks/integrated-pattern' }
        ]
      },
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/creode/wordpress-blocks' }
    ]
  }
})
