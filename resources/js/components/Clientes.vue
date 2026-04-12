<template>
    <div class="w-full max-w-6xl rounded-lg bg-white p-6 shadow-md">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-[#303030]">Clientes</h1>
            <a
                href="/anadir-cliente"
                class="inline-block rounded-lg border border-[#E5E2F4] bg-[#54805B] px-6 py-2 font-medium text-white shadow-md transition-all hover:shadow-lg"
            >
                Añadir Cliente
            </a>
        </div>

        <div class="mb-6 flex gap-4">
            <div class="max-w-xs flex-1">
                <input
                    type="text"
                    placeholder="Buscar clientes"
                    class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-blue-500 focus:outline-none"
                />
            </div>

            <select class="rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none">
                <option>Tipo</option>
                <option>Cliente</option>
                <option>Proveedor</option>
            </select>

            <select class="rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none">
                <option>Países</option>
                <option>España</option>
                <option>Francia</option>
                <option>Alemania</option>
            </select>
        </div>

        <div class="-mx-6">
            <div class="border-t border-gray-300 bg-[#F3F0F4]/70"></div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-[#F3F0F4]/70">
                        <tr class="text-left text-sm text-gray-500">
                            <th class="px-6 pb-3 font-semibold">ID</th>
                            <th class="px-6 pb-3 font-semibold">Nombre</th>
                            <th class="px-6 pb-3 font-semibold">Tipo</th>
                            <th class="px-6 pb-3 font-semibold">País</th>
                            <th class="px-6 pb-3 text-right font-semibold">Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">CLI-00001</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">ElectraPower Distribution S.L.</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Cliente</td>
                            <td class="px-6 py-4 text-sm text-gray-600">España</td>
                            <td class="px-6 py-4 text-right">
                                <a href="/editar-cliente" class="mr-2 text-gray-600 hover:text-gray-900">Editar</a>
                                <a href="/editar-cliente" class="text-gray-600 hover:text-gray-900">></a>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">CLI-00002</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Automotriz EuroParts S.A.</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Cliente</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Alemania</td>
                            <td class="px-6 py-4 text-right">
                                <a href="/editar-cliente" class="mr-2 text-gray-600 hover:text-gray-900">Editar</a>
                                <a href="/editar-cliente" class="text-gray-600 hover:text-gray-900">></a>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">CLI-00003</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">MedSeaFish Co.</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Cliente</td>
                            <td class="px-6 py-4 text-sm text-gray-600">España</td>
                            <td class="px-6 py-4 text-right">
                                <a href="/editar-cliente" class="mr-2 text-gray-600 hover:text-gray-900">Editar</a>
                                <a href="/editar-cliente" class="text-gray-600 hover:text-gray-900">></a>
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
