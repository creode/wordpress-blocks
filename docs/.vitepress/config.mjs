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
          { text: 'The Block Class', link: '/the-block-class' },
          { text: 'Creation', link: '/block-creation' },
          { text: 'Order', link: '/order-of-blocks' },
          { text: 'Categorization', link: '/block-categorization' },
          { text: 'Fields', link: '/block-fields' },
          { text: 'Supports', link: '/block-supports' },
          { text: 'Templates', link: '/block-template' },
          { text: 'Child Blocks', link: '/child-blocks' }
        ]
      },
      {
        text: 'Block Traits',
        collapsed: false,
        items: [
          { text: 'Introduction', link: '/block-traits-introduction' },
		  { text: 'Auto Initialization', link: '/block-trait-auto-initialization' }
        ]
      },
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/creode/wordpress-blocks' }
    ]
  }
})
