import './bootstrap';
import { createApp, defineAsyncComponent } from 'vue/dist/vue.esm-bundler';
import Pestana from './components/auth/Pestana.vue';
import Header from './components/auth/Header.vue';
import CajasContacto from './components/auth/CajasContacto.vue';
import InfoAdicional from './components/auth/InfoAdicional.vue';
import Input from './components/auth/Input.vue';
import BotonDegraciado from './components/auth/BotonDegraciado.vue';
import CardsComponent from './components/auth/CardsComponent.vue';
import RegisterPage from './paginas/Register.vue';
import QuienesSomos from './paginas/QuienesSomos.vue';

const app = createApp({});

app.component('pestana-component', Pestana);
app.component('header-component', Header);
app.component('cajas-contacto', CajasContacto);
app.component('info-adicional', InfoAdicional);
app.component('input-component', Input);
app.component('boton-degradado', BotonDegraciado);
app.component('register-page', RegisterPage);
app.component('quienes-somos', QuienesSomos);
app.component('cards-component', CardsComponent);
app.mount('#app');
