import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Pestana from './components/auth/Pestana.vue';

const app = createApp({});

app.mount('#app');

app.component('pestana-component', Pestana);
