

import { createApp } from 'vue';
import router from "./router/index.js";
import './assets/style.scss'
import PrimeVue from 'primevue/config';
import HomeView from "@/views/HomeView.vue";



const app = createApp({});
app.component(HomeView)
app.use(router)
app.use(PrimeVue)

app.mount('#app');
