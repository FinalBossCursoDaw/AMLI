<script setup lang="ts">
interface DatosCliente {
    nombreEmpresa: string;
    cifNif: string;
    pais: string;
    direccion: string;
    ciudad: string;
    codigoPostal: string;
    contacto: string;
    email: string;
    telefono: string;
}
interface Pais {
    id: number;
    nom: string;
}

defineProps<{
    datosIniciales: DatosCliente;
    paisesDisponibles: Pais[];
    ciudadesDisponibles: string[];
}>();

const emit = defineEmits([
    'cambiar-pais',
    'cambiar-ciudad',
    'cambiar-nombre-empresa',
    'cambiar-cif',
    'cambiar-direccion',
    'cambiar-codigo-postal',
    'cambiar-contacto',
    'cambiar-email',
    'cambiar-telefono',
]);

const alCambiarPais = (event: Event) => {
    const select = event.target as HTMLSelectElement;
    emit('cambiar-pais', select.value);
};

const alCambiarCiudad = (event: Event) => {
    const select = event.target as HTMLSelectElement;
    emit('cambiar-ciudad', select.value);
};

const alCambiarNombreEmpresa = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-nombre-empresa', input.value);
};

const alCambiarCif = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-cif', input.value);
};

const alCambiarDireccion = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-direccion', input.value);
};

const alCambiarCodigoPostal = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-codigo-postal', input.value);
};

const alCambiarContacto = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-contacto', input.value);
};

const alCambiarEmail = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-email', input.value);
};

const alCambiarTelefono = (event: Event) => {
    const input = event.target as HTMLInputElement;
    emit('cambiar-telefono', input.value);
};

</script>

<template>
    <section class="rounded-lg border border-[#d9d2d5] bg-white shadow-sm">
        <div class="border-b border-[#e6e0e2] px-5 py-4">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#383536]">Datos del cliente</h2>
        </div>

        <div class="space-y-6 px-5 py-5">
            <div class="space-y-3">
                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Nombre de empresa</label>
                    <input
                        :value="datosIniciales.nombreEmpresa"
                        type="text"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                        @input="alCambiarNombreEmpresa"
                    />
                </div>

                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">NIF o CIF</label>
                    <input
                        :value="datosIniciales.cifNif"
                        type="text"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                        @input="alCambiarCif"   
                    />
                </div>
<div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Pais</label>
    <select
        :value="datosIniciales.pais"
        @change="alCambiarPais"
        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
    >
        <option value="">Selecciona un pais</option>

        <option
            v-for="pais in paisesDisponibles"
            :key="pais.id"
            :value="pais.nom"
        >
            {{ pais.nom }}
        </option>
    </select>
</div>


                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Direccion</label>
                    <input
                        :value="datosIniciales.direccion"
                        type="text"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                        @input="alCambiarDireccion"
                    />
                </div>
<div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Ciudad</label>
    <select
        :value="datosIniciales.ciudad"
        @change="alCambiarCiudad"
        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
    >
        <option value="">Selecciona una ciudad</option>

        <option
            v-for="ciudad in ciudadesDisponibles"
            :key="ciudad"
            :value="ciudad"
        >
            {{ ciudad }}
        </option>
    </select>
</div>

                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Codigo postal</label>
                    <input
                        :value="datosIniciales.codigoPostal"
                        type="text"
                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                        @input="alCambiarCodigoPostal"
                    />
                </div>
            </div>

            <div class="border-t border-[#ebe6e8] pt-5">
                <h3 class="mb-3 font-montserrat text-[14px] font-semibold text-[#383536]">Datos del contacto</h3>

                <div class="space-y-3">
                    <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                        <label class="font-montserrat text-[11px] text-[#5f5a5b]">Contacto</label>
                        <input
                            :value="datosIniciales.contacto"
                            type="text"
                            class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                            @input="alCambiarContacto"
                        />
                    </div>

                    <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                        <label class="font-montserrat text-[11px] text-[#5f5a5b]">Email</label>
                        <input
                            :value="datosIniciales.email"
                            type="email"
                            class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                            @input="alCambiarEmail"
                        />
                    </div>

                    <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                        <label class="font-montserrat text-[11px] text-[#5f5a5b]">Telefono</label>
                        <input
                            :value="datosIniciales.telefono"
                            type="text"
                            class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                            @input="alCambiarTelefono"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
