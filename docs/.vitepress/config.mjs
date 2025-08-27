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
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/creode/wordpress-blocks' }
    ]
  }
})
