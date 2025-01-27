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
          { text: 'What Is This Plugin?', link: '/what-is-it' },
          { text: 'Quick Start', link: '/quick-start' }
        ]
      },
      {
        text: 'Blocks',
        items: [
          { text: 'The Block Class', link: '/the-block-class' },
          { text: 'Block Creation', link: '/block-creation' },
          { text: 'Order Of Blocks', link: '/order-of-blocks' },
          { text: 'Block Categorization', link: '/block-categorization' },
          { text: 'Block Fields', link: '/block-fields' },
          { text: 'Block Supports', link: '/block-supports' },
          { text: 'The Block Template', link: '/the-block-template' }
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/creode/wordpress-blocks' }
    ]
  }
})
