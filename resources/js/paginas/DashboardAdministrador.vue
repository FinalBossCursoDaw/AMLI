<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <header-registrado
            title="Dashboard"
        />

        <div class="px-10 mt-20">
            <div class="mx-auto flex max-w-6xl flex-col items-start gap-8">
                <div class="w-fit">
                    <stats-card
                        icono="/imagenes/iconoUsuarios.png"
                        :iconoType="'image'"
                        label="Clientes"
                        api-url="/api/clientes-count"
                    />
                </div>

                <div class="w-full">
                    <clientes-tabla />
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
</script>

<style lang="scss" scoped>
</style>
