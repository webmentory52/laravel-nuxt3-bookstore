
export default defineNuxtConfig({
  modules: ['@nuxtjs/tailwindcss'],
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
    runtimeConfig: {
        public: {
            apiBase: ''
        }
    },
    css: ['~/assets/css/tailwind.css'],
})
