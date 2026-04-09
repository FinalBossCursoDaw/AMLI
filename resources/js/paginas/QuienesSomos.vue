<template>
    <header-component />
    <main class="min-h-screen bg-[#f3f1f3] relative">  
 <div class="container mx-auto px-4 pt-24 pb-12 ">
        
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
                            />
                </div>
            </div>
            
            <!-- Imagen Derecha -->
            <div class="flex justify-center">
                <img src="/imagenes/caminion.png" alt="Camión AMLI" class="max-w-full h-auto">
            </div>
        </div>
        
        <cards-component />
      
        <!-- Nuestros valores -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-8">
                Nuestros <span class="text-red-600">valores</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Eficiencia -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-3xl mb-2">⚡</div>
                    <h4 class="font-bold text-lg">Eficiencia</h4>
                </div>
                
                <!-- Transparencia -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-3xl mb-2">🔍</div>
                    <h4 class="font-bold text-lg">Transparencia</h4>
                </div>
                
                <!-- Innovación -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-3xl mb-2">💡</div>
                    <h4 class="font-bold text-lg">Innovación</h4>
                </div>
                
                <!-- Confianza -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-3xl mb-2">🤝</div>
                    <h4 class="font-bold text-lg">Confianza</h4>
                </div>
            </div>
        </div>
    </div>

    </main>
   
</template>

<script setup>
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>
