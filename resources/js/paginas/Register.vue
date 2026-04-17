<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';
import HeaderComponent from '../components/Header.vue';
import InputComponent from '../components/Input.vue';
import BotonDegradado from '../components/BotonDegraciado.vue';

const correu = ref('');
const contrasenya = ref('');
const error = ref('');
const loading = ref(false);

const handleLogin = async () => {
    loading.value = true;
    error.value = '';

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const registerUrl = new URL('/register', window.location.origin).toString();

    try {
        const response = await axios.post(registerUrl, {
            correu: correu.value,
            contrasenya: contrasenya.value,
        }, {
            headers: {
                'X-CSRF-TOKEN': token || '',
                'Accept': 'application/json',
            },
        });

        const redirectPath = response.data?.redirect || '/dashboard-admin';
        window.location.href = new URL(redirectPath, window.location.origin).toString();
    } catch (e) {
        error.value = axios.isAxiosError(e)
            ? e.response?.data?.errors?.correu?.[0] || e.response?.data?.error || 'Credenciales incorrectas'
            : 'Error de conexion';
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <HeaderComponent />
    <main class="min-h-screen bg-[#f3f1f3] relative">
        <section class="flex min-h-screen w-full">
            <div class="relative min-h-screen w-full overflow-hidden bg-[#f3f1f3]">
                <img
                    alt=""
                    aria-hidden="true"
                    class="pointer-events-none absolute right-[180px] top-0 z-0 h-full w-[480px] max-w-none select-none object-cover sm:right-[380px] sm:w-[600px] lg:right-[580px] lg:w-[720px]"
                    src="/imagenes/rayas.png"
                />

                <div class="absolute right-[120px] top-1/2 z-20 hidden h-[560px] w-[420px] -translate-y-1/2 rounded-[22px] border border-[#e6dfdf] bg-white shadow-[0_8px_20px_rgba(0,0,0,0.18)] lg:block xl:right-[220px] xl:h-[590px] xl:w-[450px]">
                    <div class="flex flex-col px-12 pt-12">
                        <h2 class="mb-3 text-center font-montserrat text-4xl font-extrabold text-[#2F2E30]">
                            Iniciar sesion
                        </h2>
                        <p class="mb-8 text-center font-montserrat text-lg text-[#AAABAA]">
                            Introduce tus credenciales
                        </p>

                        <p v-if="error" class="mb-4 text-sm text-red-500">{{ error }}</p>

                        <p class="mt-8 mb-2 font-montserrat text-sm font-semibold text-[#2F2E30]">Email</p>
                        <InputComponent
                            v-model="correu"
                            placeholder="Introduce el email"
                            type="email"
                            icon="email"
                        />

                        <p class="mt-8 mb-2 font-montserrat text-sm font-semibold text-[#2F2E30]">Contrasena</p>
                        <InputComponent
                            v-model="contrasenya"
                            placeholder="Introduce la contrasena"
                            type="password"
                            icon="lock"
                        />

                        <div class="mt-8">
                            <BotonDegradado
                                text="Entrar"
                                :show-arrow="true"
                                :disabled="loading"
                                type="button"
                                @click="handleLogin"
                            />
                        </div>
                    </div>
                </div>

                <div class="relative z-10 ml-16 mt-20 max-w-[520px] sm:ml-24 sm:mt-24 lg:ml-32 lg:mt-28">
                    <p class="font-montserrat text-[clamp(2.5rem,5.1vw,4.25rem)] font-medium leading-none tracking-[-0.04em] text-[#111111]">
                        Accede a
                    </p>
                    <h1 class="mt-2 relative font-montserrat text-[clamp(3rem,4.5vw,5rem)] font-bold leading-none tracking-[-0.05em] text-[#cb0c14]">
                        AMLI
                    </h1>
                    <div class="mt-4 relative h-1 w-28 bg-[#cb0c14] sm:w-36 lg:mt-5 lg:w-40"></div>
                    <p class="mt-6 max-w-[28ch] font-montserrat text-[clamp(1.25rem,2.25vw,2.15rem)] leading-[1.18] text-[#121212] lg:mt-7">
                        Gestiona ofertas, operaciones y seguimiento
                        <span class="font-semibold">en un solo lugar</span>
                    </p>
                </div>

                <div class="relative mt-40 flex items-end justify-center sm:mt-44 lg:justify-start">
                    <img
                        alt="Camion de AMLI Logistics"
                        class="pointer-events-none relative z-10 w-[650px] max-w-[140%] translate-x-8 select-none drop-shadow-[0_24px_30px_rgba(0,0,0,0.2)] sm:w-[800px] sm:max-w-[125%] sm:translate-x-12 lg:w-[920px] lg:max-w-none lg:translate-x-16"
                        src="/imagenes/caminion.png"
                    />
                </div>
            </div>
        </section>
    </main>
</template>
