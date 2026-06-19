<script setup>
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'
</script>

<template>
    <div class="flex min-h-screen flex-col bg-paper">
        <AppHeader />
        <main class="flex-1 pt-16 lg:pt-20">
            <slot />
        </main>
        <AppFooter />
    </div>
</template>
