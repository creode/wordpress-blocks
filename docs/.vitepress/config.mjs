import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "WordPress Blocks Plugin",
  description: "Serves as developer Documentation for the WordPress Blocks Plugin",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'API Documentation', link: 'api/index.html' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        collapsed: false,
        items: [
          { text: 'What is this plugin?', link: '/what-is-it' },
          { text: 'Quick Start', link: '/quick-start' }
        ]
      },
      {
        text: 'Blocks',
        items: [
          { text: 'Creation', link: '/block-creation' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/creode/wordpress-blocks' }
    ]
  }
})
