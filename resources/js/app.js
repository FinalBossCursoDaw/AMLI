import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Pestana from './components/auth/Pestana.vue';
import Header from './components/auth/Header.vue';
import CajasContacto from './components/auth/CajasContacto.vue';
import InfoAdicional from './components/auth/InfoAdicional.vue';

const app = createApp({});

app.component('pestana-component', Pestana);
app.component('header-component', Header);
app.component('cajas-contacto', CajasContacto);
app.component('info-adicional', InfoAdicional);

app.mount('#app');
