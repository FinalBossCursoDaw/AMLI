<script setup lang="ts">
import { reactive, ref } from 'vue';

interface DatosAcceso {
    usuario: string;
    contrasena: string;
    rol: string;
    usuarioActivo: boolean;
}

const props = defineProps<{
    datosIniciales: DatosAcceso;
    rolesDisponibles: string[];
}>();

const emit = defineEmits(['guardar-cambios']);


const formularioAcceso = reactive({
    ...props.datosIniciales,
});

const usuarioActivo = ref(props.datosIniciales.usuarioActivo);

const cambiarEstadoUsuario = () => {
    usuarioActivo.value = !usuarioActivo.value;
};
</script>

<template>
    <section class="rounded-lg border border-[#d9d2d5] bg-white shadow-sm">
        <div class="border-b border-[#e6e0e2] px-5 py-4">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#383536]">Accesos y permisos</h2>
        </div>

        <div class="space-y-5 px-5 py-5">
            <div class="space-y-3">
                <div class="grid gap-3 sm:grid-cols-[104px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Usuario</label>
                    <input
                        v-model="formularioAcceso.usuario"
                        type="text"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                    />
                </div>

                <div class="grid gap-3 sm:grid-cols-[104px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Contrasena</label>
                    <input
                        v-model="formularioAcceso.contrasena"
                        type="text"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                    />
                </div>

                <div class="grid gap-3 sm:grid-cols-[104px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Rol</label>
                    <select
                        v-model="formularioAcceso.rol"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                    >
                        <option
                            v-for="rol in rolesDisponibles"
                            :key="rol"
                            :value="rol"
                        >
                            {{ rol }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="border-t border-[#ebe6e8] pt-5">
                <h3 class="mb-4 font-montserrat text-[14px] font-semibold text-[#383536]">Estado del usuario</h3>

                <div class="mb-5 flex items-center justify-between gap-4">
                    <span class="font-montserrat text-[11px] text-[#5f5a5b]">Usuario activo</span>

                    <button
                        type="button"
                        :class="[
                            'relative h-6 w-11 rounded-full transition',
                            usuarioActivo ? 'bg-[#4f815d]' : 'bg-[#f44336]'
                        ]"
                        @click="cambiarEstadoUsuario"
                    >
                        <span
                            :class="[
                                'absolute top-1 h-4 w-4 rounded-full bg-white shadow-sm transition-all',
                                usuarioActivo ? 'left-6' : 'left-1'
                            ]"
                        ></span>
                    </button>
                </div>

                <button
                    type="button"
                    class="rounded-[4px] bg-[#f1efef] px-4 py-2 font-montserrat text-[10px] font-semibold text-[#5b5758] transition hover:bg-[#e6e1e2]"
                >
                    Restablecer contrasena
                </button>
            </div>

            <div class="border-t border-[#ebe6e8] pt-5">
                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        class="rounded-[4px] border border-[#d8d2d4] bg-white px-5 py-2 font-montserrat text-[11px] font-semibold text-[#5b5758] transition hover:bg-[#f5f3f4]"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        class="rounded-[4px] bg-[#5b8a61] px-5 py-2 font-montserrat text-[11px] font-semibold text-white shadow-sm transition hover:bg-[#507b56]"
                        @click="emit('guardar-cambios')"
                    >
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
