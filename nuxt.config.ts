// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-04-03',
  devtools: { enabled: true },
  
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
