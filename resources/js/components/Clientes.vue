<template>
    <div class="w-full max-w-6xl rounded-lg bg-white p-6 shadow-md">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-[#303030]">Clientes</h1>
            <button 
                class="text-white px-6 py-2 rounded-lg font-medium transition-all bg-[#54805B] border border-[#E5E2F4] shadow-md hover:shadow-lg"
            >
                Añadir Cliente
            </button>
        </div>

        <!-- Filtros -->
        <div class="flex gap-4 mb-6">
            <div class="flex-1 max-w-xs">
                <input 
                    type="text"
                    placeholder="Buscar clientes"
                    class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                />
            </div>
            <select class="px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500">
                <option>Tipo</option>
                <option>Cliente</option>
                <option>Proveedor</option>
            </select>
            <select class="px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500">
                <option>Países</option>
                <option>España</option>
                <option>Francia</option>
                <option>Alemania</option>
            </select>
        </div>

        <!-- Tabla -->
        <div class="-mx-6">
            <!-- Línea separatoria -->
            <div class="border-t border-gray-300 bg-[#F3F0F4]/70"></div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-[#F3F0F4]/70">
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="pb-3 font-semibold px-6">ID</th>
                            <th class="pb-3 font-semibold px-6">Nombre</th>
                            <th class="pb-3 font-semibold px-6">Tipo</th>
                            <th class="pb-3 font-semibold px-6">País</th>
                            <th class="pb-3 font-semibold px-6 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 text-sm text-gray-600 px-6">CLI-00001</td>
                            <td class="py-4 text-sm text-gray-900 font-medium px-6">ElectraPower Distribution S.L.</td>
                            <td class="py-4 text-sm text-gray-600 px-6">Cliente</td>
                            <td class="py-4 text-sm text-gray-600 px-6">España</td>
                            <td class="py-4 text-right px-6">
                                <button class="text-gray-600 hover:text-gray-900 mr-2">Editar</button>
                                <button class="text-gray-600 hover:text-gray-900">→</button>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 text-sm text-gray-600 px-6">CLI-00002</td>
                            <td class="py-4 text-sm text-gray-900 font-medium px-6">Automotriz EuroParts S.A.</td>
                            <td class="py-4 text-sm text-gray-600 px-6">Cliente</td>
                            <td class="py-4 text-sm text-gray-600 px-6">Alemania</td>
                            <td class="py-4 text-right px-6">
                                <button class="text-gray-600 hover:text-gray-900 mr-2">Editar</button>
                                <button class="text-gray-600 hover:text-gray-900">→</button>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 text-sm text-gray-600 px-6">CLI-00003</td>
                            <td class="py-4 text-sm text-gray-900 font-medium px-6">MedSeaFish Co.</td>
                            <td class="py-4 text-sm text-gray-600 px-6">Cliente</td>
                            <td class="py-4 text-sm text-gray-600 px-6">España</td>
                            <td class="py-4 text-right px-6">
                                <button class="text-gray-600 hover:text-gray-900 mr-2">Editar</button>
                                <button class="text-gray-600 hover:text-gray-900">→</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>
thead {
  margin-left: -1.5rem;
  margin-right: -1.5rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}
</style>
