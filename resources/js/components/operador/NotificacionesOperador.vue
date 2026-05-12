<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const notificaciones = ref([]);
const cargando = ref(true);
const error = ref('');

const obtenerIcono = (tipoNotificacionId) => {
    if (tipoNotificacionId === 2) {
        return 'O';
    }

    return '!';
};

const obtenerColor = (tipoNotificacionId) => {
    if (tipoNotificacionId === 2) {
        return 'bg-[#4d78ff]';
    }

    return 'bg-[#f1b645]';
};

const cargarNotificaciones = async () => {
    try {
        cargando.value = true;
        error.value = '';

        const response = await axios.get('/api/notificaciones/ultimas');
        notificaciones.value = response.data;
    } catch (e) {
        error.value = 'No se han podido cargar las notificaciones';
    } finally {
        cargando.value = false;
    }
};

onMounted(() => {
    cargarNotificaciones();
});
</script>

<template>
    <aside class="flex flex-col">
        <section class="overflow-hidden rounded-lg border border-[#d8d1d3] bg-white shadow-[0_14px_32px_rgba(48,48,48,0.08)]">
            <div class="flex items-center justify-between gap-3 border-b border-[#ebe6e8] bg-[#fffdfd] px-5 py-3">
                <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Ultimas notificaciones</h2>
                <a
                    href="#"
                    class="inline-flex h-8 items-center justify-center rounded-md border border-[#c9171d] px-4 font-montserrat text-[12px] font-semibold text-[#c9171d] transition hover:bg-[#c9171d] hover:text-white"
                >
                    Ver
                </a>
            </div>

            <div class="divide-y divide-[#ebe6e8]">
                <div v-if="cargando" class="px-4 py-4 font-montserrat text-[12px] text-[#6b6567]">
                    Cargando notificaciones...
                </div>

                <div v-else-if="error" class="px-4 py-4 font-montserrat text-[12px] text-[#c9171d]">
                    {{ error }}
                </div>

                <div v-else-if="notificaciones.length === 0" class="px-4 py-4 font-montserrat text-[12px] text-[#6b6567]">
                    No tienes notificaciones recientes.
                </div>

                <template v-else>
                    <div
                        v-for="notificacion in notificaciones"
                        :key="notificacion.id"
                        class="group flex items-center gap-3 px-4 py-4 transition hover:bg-[#fff8f8]"
                    >
                        <div :class="[obtenerColor(notificacion.tipus_notificacio_id), 'flex h-10 w-10 flex-none items-center justify-center rounded-md text-lg font-semibold text-white shadow-sm transition group-hover:scale-105']">
                            {{ obtenerIcono(notificacion.tipus_notificacio_id) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-montserrat text-[12px] font-semibold leading-5 text-[#353233]">{{ notificacion.titol }}</p>
                            <p class="font-montserrat text-[12px] leading-5 text-[#4f4a4b]">{{ notificacion.missatge }}</p>
                        </div>
                        <span class="text-[22px] text-[#c9171d] transition group-hover:translate-x-1">></span>
                    </div>
                </template>
            </div>
        </section>

        <div class="mt-6 flex justify-end gap-3">
            <a
                href="/ofertas"
                class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-semibold text-[#5f5a5b] shadow-sm transition hover:-translate-y-0.5 hover:border-[#c9171d] hover:text-[#c9171d]"
            >
                Ver todas las ofertas
                <span class="text-[#ff2424]">></span>
            </a>

            <a
                href="#"
                class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-semibold text-[#5f5a5b] shadow-sm transition hover:-translate-y-0.5 hover:border-[#c9171d] hover:text-[#c9171d]"
            >
                Ver todas las operaciones
                <span class="text-[#ff2424]">></span>
            </a>
        </div>
    </aside>
</template>
