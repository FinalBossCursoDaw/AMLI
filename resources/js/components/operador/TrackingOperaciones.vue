<script setup>
import HeaderRegistrado from '../Header-registrado.vue';
import NavIzquierda from '../Navizquierda.vue';
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';


const props = defineProps({
  operacionId: String,
  cliente: String,
  puertoOrigen: String,
  puertoDestino: String,
});


const menuOperativo = computed(() => {
    return [
        { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
        { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
        { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
    ];
});
</script>


<template>
  <main class="amli-page">
    <div class="fixed inset-x-0 top-0 z-30">
      <HeaderRegistrado title="Tracking" subtitle="Seguimiento de la operación" />
    </div>

    <NavIzquierda :items="menuOperativo" />

    <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
      <div class="mx-auto max-w-[1180px] space-y-8">
        <!-- Información de la operación -->
        <div class="amli-panel p-8">
          <h2 class="text-lg font-semibold text-[#353233] mb-8 pb-6 border-b border-[#eee8ea]">Información de la Operación</h2>
          <div class="grid grid-cols-4 gap-8">
            <div>
              <p class="text-xs font-semibold text-[#8e8588] uppercase tracking-wide mb-3">ID Operación</p>
              <p class="text-base font-semibold text-[#353233]">{{ operacionId }}</p>
            </div>  
            <div>
              <p class="text-xs font-semibold text-[#8e8588] uppercase tracking-wide mb-3">Cliente</p>
              <p class="text-base font-semibold text-[#353233]">{{ cliente }}</p>
            </div>
            <div>
              <p class="text-xs font-semibold text-[#8e8588] uppercase tracking-wide mb-3">Origen</p>
              <p class="text-base font-semibold text-[#353233]">{{ puertoOrigen }}</p>
            </div>
            <div>
              <p class="text-xs font-semibold text-[#8e8588] uppercase tracking-wide mb-3">Destino</p>
              <p class="text-base font-semibold text-[#353233]">{{ puertoDestino }}</p>
            </div>
          </div>
        </div>

        <!-- Actualizar tracking -->
        <div class="amli-panel p-8">
          <h2 class="text-lg font-semibold text-[#353233] mb-8 pb-6 border-b border-[#eee8ea]">Actualizar Tracking</h2>
          
          <form class="space-y-8">
            <!-- Select de pasos -->
            <div>
              <label class="block text-sm font-semibold text-[#353233] mb-4">Selecciona el paso</label>
              <select class="w-full rounded-lg border border-[#e6dedf] bg-white px-4 py-3 text-[#353233] font-medium focus:outline-none focus:border-[#c9171d] focus:ring-2 focus:ring-[#c9171d] focus:ring-opacity-10 transition">
                <option value="1">1. Preparacio</option>
                <option value="2">2. Transport interior origen</option>
                <option value="3">3. Terminal/Port origen</option>
                <option value="4">4. Carrega a bord</option>
                <option value="5">5. Transit</option>
                <option value="6">6. Port desti</option>
                <option value="7">7. Aduana importacio</option>
                <option value="8">8. Transport interior desti</option>
                <option value="9">9. Entrega final</option>
              </select>
            </div>

            <!-- Estado del paso -->
            <div>
              <label class="block text-sm font-semibold text-[#353233] mb-5">Estado</label>
              <div class="flex gap-8">
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="radio" name="estado" value="pendiente" class="w-5 h-5 text-[#c9171d] accent-[#c9171d]">
                  <span class="text-sm font-medium text-[#353233]">Pendiente</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="radio" name="estado" value="en_curso" class="w-5 h-5 text-[#c9171d] accent-[#c9171d]">
                  <span class="text-sm font-medium text-[#353233]">En curso</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="radio" name="estado" value="completado" class="w-5 h-5 text-[#c9171d] accent-[#c9171d]">
                  <span class="text-sm font-medium text-[#353233]">Completado</span>
                </label>
              </div>
            </div>

            <!-- Botón confirmar -->
            <div class="pt-4">
              <button type="button" class="rounded-lg bg-[#c9171d] px-8 py-3 text-white font-semibold text-sm transition duration-200 hover:bg-[#a01219] active:scale-95 shadow-sm hover:shadow-md">
                Confirmar
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
</template>