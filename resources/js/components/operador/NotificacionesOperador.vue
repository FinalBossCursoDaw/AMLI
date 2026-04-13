<script setup>
const notificaciones = [
    { id: 1, icono: 'R', color: 'bg-[#4d78ff]', texto: 'La operacion OP-00098 se ha actualizado al estado' },
    { id: 2, icono: 'X', color: 'bg-[#f44336]', texto: 'La oferta #00023 ha sido rechazada' },
    { id: 3, icono: '+', color: 'bg-[#5b8a61]', texto: 'Nueva operacion creada: OP-00101' },
    { id: 4, icono: '!', color: 'bg-[#f1b645]', texto: 'Incidencia abierta en la operacion OP-0095' },
];
</script>

<template>
    <aside class="flex flex-col">
        <section class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
            <div class="border-b border-[#ebe6e8] px-5 py-3">
                <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Ultimas notificaciones</h2>
            </div>

            <div class="divide-y divide-[#ebe6e8]">
                <div
                    v-for="notificacion in notificaciones"
                    :key="notificacion.id"
                    class="flex items-center gap-3 px-4 py-4"
                >
                    <div :class="[notificacion.color, 'flex h-10 w-10 flex-none items-center justify-center rounded-md text-lg font-semibold text-white']">
                        {{ notificacion.icono }}
                    </div>
                    <p class="flex-1 font-montserrat text-[12px] leading-5 text-[#4f4a4b]">{{ notificacion.texto }}</p>
                    <span class="text-[22px] text-[#353233]">></span>
                </div>
            </div>
        </section>

        <div class="mt-6 flex justify-end gap-3">
            <a
                href="/ofertas"
                class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]"
            >
                Ver todas las ofertas
                <span class="text-[#ff2424]">></span>
            </a>

            <a
                href="#"
                class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]"
            >
                Ver todas las operaciones
                <span class="text-[#ff2424]">></span>
            </a>
        </div>
    </aside>
</template>
