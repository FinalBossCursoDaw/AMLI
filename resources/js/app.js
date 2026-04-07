import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Pestana from './components/auth/Pestana.vue';
import Header from './components/auth/Header.vue';
import Input from './components/auth/Input.vue';
import BotonDegraciado from './components/auth/BotonDegraciado.vue';

const app = createApp({});

app.component('pestana-component', Pestana);
app.component('header-component', Header);
app.component('input-component', Input);
app.component('boton-degradado', BotonDegraciado);

app.mount('#app');
