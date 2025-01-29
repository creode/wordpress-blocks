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
		  { text: 'Auto Initialization', link: '/block-traits/auto-initialization' }
        ]
      },
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/creode/wordpress-blocks' }
    ]
  }
})
