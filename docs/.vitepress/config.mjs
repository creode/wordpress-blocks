import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "WordPress Blocks Plugin",
  description: "Serves as developer Documentation for the WordPress Blocks Plugin",
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
          { text: 'Quick Start', link: '/quick-start' }
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
          {
            text: 'Available Traits',
            items: [
                { text: 'Editor Restriction', link: '/block-traits/traits/editor-restriction' },
                { text: 'Unique ID', link: '/block-traits/traits/unique-id' },
                { text: 'Modifier Classes', link: '/block-traits/traits/modifier-classes' },
                { text: 'Reduce Bottom Spacing', link: '/block-traits/traits/reduce-bottom-spacing' },
                { text: 'Pattern Rendering', link: '/block-traits/traits/pattern-rendering' },
                { text: 'Menu Rendering', link: '/block-traits/traits/menu-rendering' },
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
