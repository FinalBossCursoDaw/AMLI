<script setup lang="ts">
import { ref } from 'vue';

interface FormData {
    nombreEmpresa: string;
    cifNif: string;
    pais: string;
    ciudad: string;
    codigoPostal: string;
    direccion: string;
    nombreContacto: string;
    correoElectronico: string;
    telefono: string;
}

const formData = ref<FormData>({
    nombreEmpresa: '',
    cifNif: '',
    pais: '',
    ciudad: '',
    codigoPostal: '',
    direccion: '',
    nombreContacto: '',
    correoElectronico: '',
    telefono: ''
});

const handleSubmit = () => {
    console.log('Formulario enviado:', formData.value);
    // Aquí irá la lógica del backend
};

const paises = ['España', 'Francia', 'Italia', 'Alemania', 'Portugal', 'Otros'];
</script>

<template>
    <div class="max-w-4xl mx-auto p-8">
        <form @submit.prevent="handleSubmit" class="bg-white rounded-lg shadow-lg p-8 space-y-8">
            
            <!-- Datos de la empresa -->
            <div class="space-y-4">
                <h2 class="text-2xl font-montserrat font-bold text-[#303030] border-b-4 border-[#cb0c14] pb-2">
                    Datos de la empresa
                </h2>
                
                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Nombre de la empresa
                    </label>
                    <input
                        v-model="formData.nombreEmpresa"
                        type="text"
                        placeholder="Nombre de la empresa"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                    />
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        CIF/NIF
                    </label>
                    <input
                        v-model="formData.cifNif"
                        type="text"
                        placeholder="CIF/NIF"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                    />
                </div>
            </div>

            <!-- Dirección -->
            <div class="space-y-4">
                <h2 class="text-2xl font-montserrat font-bold text-[#303030] border-b-4 border-[#cb0c14] pb-2">
                    Dirección
                </h2>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        País
                    </label>
                    <select
                        v-model="formData.pais"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                    >
                        <option value="">Selecciona un país</option>
                        <option v-for="pais in paises" :key="pais" :value="pais">
                            {{ pais }}
                        </option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                            Ciudad
                        </label>
                        <input
                            v-model="formData.ciudad"
                            type="text"
                            placeholder="Ciudad"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                            Código Postal
                        </label>
                        <input
                            v-model="formData.codigoPostal"
                            type="text"
                            placeholder="Código Postal"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Dirección
                    </label>
                    <textarea
                        v-model="formData.direccion"
                        placeholder="Dirección"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors resize-none"
                    ></textarea>
                </div>
            </div>

            <!-- Persona de contacto -->
            <div class="space-y-4">
                <h2 class="text-2xl font-montserrat font-bold text-[#303030] border-b-4 border-[#cb0c14] pb-2">
                    Persona de contacto
                </h2>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Nombre del contacto
                    </label>
                    <input
                        v-model="formData.nombreContacto"
                        type="text"
                        placeholder="Nombre del contacto"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                    />
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Correo Electrónico
                    </label>
                    <input
                        v-model="formData.correoElectronico"
                        type="email"
                        placeholder="Correo Electrónico"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                    />
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Teléfono
                    </label>
                    <input
                        v-model="formData.telefono"
                        type="tel"
                        placeholder="Teléfono"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors"
                    />
                </div>
            </div>

            <!-- Botón submit -->
            <div class="flex justify-end pt-4">
                <button
                    type="submit"
                    class="px-8 py-3 bg-[#cb0c14] text-white font-montserrat font-semibold rounded-lg hover:bg-[#a00a0f] transition-colors duration-300 shadow-lg"
                >
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
input::placeholder,
textarea::placeholder {
    @apply text-gray-400;
}

textarea {
    font-family: inherit;
}
</style>
