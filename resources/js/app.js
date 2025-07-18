import { createApp } from 'vue';
import App from './App.vue'
import router from './router/index.js';
import '../css/app.css'
import { createPinia } from 'pinia'

createApp(App)
  .use(createPinia())
  .use(router)
  .mount('#app');