// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-04-03',
  devtools: { enabled: true },
  app: {
    head: {
      title: 'comar-auth',
    },
  },
  server: {
    host: 'comar-auth',
    port: 8000,
  },
	css: [
    // SCSS file in the project
    '~/assets/css/style.scss'
  ],
  build: {
    css: {
      sass: true,
    },
  },
  port: 'http://localhost:3001'
})
