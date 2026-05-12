<template>
    <div class="amli-panel w-full max-w-6xl p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="font-montserrat text-2xl font-bold text-[#303030]">Usuarios</h1>
        </div>

        <div class="mb-6 flex gap-4">
            <div class="max-w-xs flex-1">
                <input
                    v-model="textoBusqueda"
                    type="text"
                    placeholder="Buscar usuarios"
                    class="amli-input w-full"
                />
            </div>
        </div>

        <div class="-mx-6">
            <div class="border-t border-[#ebe6e8] bg-[#f8f6f7]"></div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-[#F3F0F4]/70">
                        <tr class="text-left text-sm text-gray-500">
                            <th class="px-6 pb-3 font-semibold">Nombre</th>
                            <th class="px-6 pb-3 font-semibold">Correo</th>
                            <th class="px-6 pb-3 font-semibold">Usuario</th>
                            <th class="px-6 pb-3 font-semibold">Rol</th>
                            <th class="px-6 pb-3 text-right font-semibold">Accion</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="cargando">
                            <td colspan="5" class="px-6 py-4 text-sm text-gray-600">
                                Cargando usuarios...
                            </td>
                        </tr>

                        <tr v-else-if="error">
                            <td colspan="5" class="px-6 py-4 text-sm text-red-600">
                                {{ error }}
                            </td>
                        </tr>

                        <tr v-else-if="usuariosFiltrados.length === 0">
                            <td colspan="5" class="px-6 py-4 text-sm text-gray-600">
                                No hay usuarios para mostrar
                            </td>
                        </tr>

                        <tr
                            v-else
                            v-for="usuario in usuariosFiltrados"
                            :key="usuario.id"
                            class="border-b border-gray-100 hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ usuario.nom_complet || 'Sin nombre' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ usuario.correu }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ usuario.username }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ usuario.rol }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a :href="`/editar-cliente?tipo=usuario&id=${usuario.id}`" class="mr-2 text-gray-600 hover:text-gray-900">Editar</a>
                                <a :href="`/editar-cliente?tipo=usuario&id=${usuario.id}`" class="text-gray-600 hover:text-gray-900">></a>
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

const usuarios = ref([]);
const cargando = ref(true);
const error = ref('');
const textoBusqueda = ref('');

const usuariosFiltrados = computed(() => {
    const texto = textoBusqueda.value.toLowerCase().trim();

    if (!texto) {
        return usuarios.value;
    }

    return usuarios.value.filter((usuario) => {
        return (
            (usuario.nom_complet || '').toLowerCase().includes(texto) ||
            (usuario.correu || '').toLowerCase().includes(texto) ||
            (usuario.username || '').toLowerCase().includes(texto) ||
            (usuario.rol || '').toLowerCase().includes(texto)
        );
    });
});

const cargarUsuarios = async () => {
    try {
        cargando.value = true;
        error.value = '';

        const response = await axios.get('/api/usuarios');
        usuarios.value = response.data;
    } catch (err) {
        console.error(err);
        error.value = 'No se han podido cargar los usuarios';
    } finally {
        cargando.value = false;
    }
};

onMounted(() => {
    cargarUsuarios();
});
</script>

<style scoped>
thead {
    margin-left: -1.5rem;
    margin-right: -1.5rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

thead {
    background: #f8f6f7;
    border-color: #ebe6e8;
}

thead tr {
    color: #9f9699;
    font-family: Montserrat, sans-serif;
    font-size: 11px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

thead th {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
}

tbody tr {
    border-color: #efe9eb;
    transition: background-color 0.2s ease;
}

tbody tr:hover {
    background: #fff8f8;
}
</style>
