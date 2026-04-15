<template>
    <div class="w-full max-w-6xl rounded-lg bg-white p-6 shadow-md">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-[#303030]">Clientes</h1>

            <a
                href="/anadir-cliente"
                class="inline-block rounded-lg border border-[#E5E2F4] bg-[#54805B] px-6 py-2 font-medium text-white shadow-md transition-all hover:shadow-lg"
            >
                Añadir cliente
            </a>
        </div>

        <div class="mb-6 flex gap-4">
            <div class="max-w-xs flex-1">
                <input
                    v-model="textoBusqueda"
                    type="text"
                    placeholder="Buscar clientes"
                    class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-blue-500 focus:outline-none"
                />
            </div>
        </div>

        <div class="-mx-6">
            <div class="border-t border-gray-300 bg-[#F3F0F4]/70"></div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-[#F3F0F4]/70">
                        <tr class="text-left text-sm text-gray-500">
                            <th class="px-6 pb-3 font-semibold">Código</th>
                            <th class="px-6 pb-3 font-semibold">Empresa</th>
                            <th class="px-6 pb-3 font-semibold">Ciudad</th>
                            <th class="px-6 pb-3 font-semibold">Contacto</th>
                            <th class="px-6 pb-3 text-right font-semibold">Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="cargando">
                            <td colspan="5" class="px-6 py-4 text-sm text-gray-600">
                                Cargando clientes...
                            </td>
                        </tr>

                        <tr v-else-if="error">
                            <td colspan="5" class="px-6 py-4 text-sm text-red-600">
                                {{ error }}
                            </td>
                        </tr>

                        <tr v-else-if="clientesFiltrados.length === 0">
                            <td colspan="5" class="px-6 py-4 text-sm text-gray-600">
                                No hay clientes para mostrar
                            </td>
                        </tr>

                        <tr
                            v-else
                            v-for="cliente in clientesFiltrados"
                            :key="cliente.id"
                            class="border-b border-gray-100 hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ cliente.codi_client }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ cliente.nom_empresa }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ cliente.ciutat || 'Sin ciudad' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ cliente.contacte }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a :href="`/editar-cliente?tipo=cliente&id=${cliente.id}`" class="mr-2 text-gray-600 hover:text-gray-900">Editar</a>
                                <a :href="`/editar-cliente?tipo=cliente&id=${cliente.id}`" class="text-gray-600 hover:text-gray-900">></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';

const clientes = ref([]);
const cargando = ref(true);
const error = ref('');
const textoBusqueda = ref('');

const clientesFiltrados = computed(() => {
    const texto = textoBusqueda.value.toLowerCase().trim();

    if (!texto) {
        return clientes.value;
    }

    return clientes.value.filter((cliente) => {
        return (
            cliente.codi_client.toLowerCase().includes(texto) ||
            cliente.nom_empresa.toLowerCase().includes(texto) ||
            (cliente.ciutat || '').toLowerCase().includes(texto) ||
            (cliente.contacte || '').toLowerCase().includes(texto)
        );
    });
});

const cargarClientes = async () => {
    try {
        cargando.value = true;
        error.value = '';

        const response = await axios.get('/api/clientes');
        clientes.value = response.data;
    } catch (err) {
        console.error(err);
        error.value = 'No se han podido cargar los clientes';
    } finally {
        cargando.value = false;
    }
};

onMounted(() => {
    cargarClientes();
});
</script>

<style scoped>
thead {
    margin-left: -1.5rem;
    margin-right: -1.5rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}
</style>
