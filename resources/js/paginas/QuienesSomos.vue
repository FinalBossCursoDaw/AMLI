<template>
    <header-component />
    <main class="min-h-screen bg-[#f3f1f3] relative overflow-hidden">
        <!-- Elemento decorativo -->
        
        
 <div class="container mx-auto px-4 pt-24 pb-12 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mb-32">
            
            <div>
                <h1 class="text-5xl font-bold mb-6">
                    Quienes <span class="text-red-600">somos</span>
                </h1>
                
                <div class="mb-8 space-y-4">
                    <p class="text-lg">
                        <strong class="text-red-600">AMLI Logistics</strong> es una empresa especializada en la gestión de operaciones de <strong>importación y exportación internacional</strong>.
                    </p>
                    
                    <p class="text-lg">
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
                <img src="/imagenes/caminion.png" alt="Camión AMLI" class="max-w-full h-auto">
                
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
