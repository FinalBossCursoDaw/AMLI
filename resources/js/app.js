import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Pestana from './components/auth/Pestana.vue';
import Header from './components/auth/Header.vue';

const app = createApp({});

app.component('pestana-component', Pestana);
app.component('header-component', Header);

app.mount('#app');
