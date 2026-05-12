<template>
    <header-component />
    <main class="amli-page relative overflow-hidden">
        <!-- Elemento decorativo -->
        
        
 <div class="container relative z-10 mx-auto px-4 pb-12 pt-24">
        
        <div class="mb-24 grid grid-cols-1 items-center gap-8 lg:grid-cols-2">
            
            <div class="rounded-lg border border-[#ddd6d8] bg-white/80 p-8 shadow-[0_18px_42px_rgba(48,48,48,0.1)] backdrop-blur">
                <h1 class="mb-6 font-montserrat text-5xl font-bold text-[#303030]">
                    Quienes <span class="text-red-600">somos</span>
                </h1>
                
                <div class="mb-8 space-y-4 font-montserrat text-[#4f4a4b]">
                    <p class="text-lg leading-8">
                        <strong class="text-red-600">AMLI Logistics</strong> es una empresa especializada en la gestión de operaciones de <strong>importación y exportación internacional</strong>.
                    </p>
                    
                    <p class="text-lg leading-8">
                        Nuestra plataforma permite gestionar <strong>ofertas comerciales, operaciones logísticas</strong> y el <strong>seguimiento de envíos en tiempo real</strong>.
                    </p>
                </div>
                
                <div class="mt-8 w-80">
                            <boton-degradado 
                                text="Entra en AMLI" 
                                :show-arrow="true"
                                  href="/register"
                            />
                </div>
            </div>
            
            <!-- Imagen Derecha -->
            <div class="flex flex-col items-center">
                <img src="/imagenes/caminion.png" alt="Camión AMLI" class="h-auto max-w-full drop-shadow-[0_24px_30px_rgba(48,48,48,0.2)]">
                
            </div>
        </div>
        
        <cards-component />
      
        <!-- Nuestros valores -->
       <valores-component />
    </div>

    </main>
   
</template>

<script setup>
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>
