<script setup>
defineProps({
    color: {
        type: String,
        default: '#FF6600',
    },
})
</script>

<template>
    <span class="relative inline-block">
        <slot />
        <svg
            class="pointer-events-none absolute -bottom-1 left-0 w-full overflow-visible"
            viewBox="0 0 200 9"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
            preserveAspectRatio="none"
        >
            <path
                d="M2 7 C20 3, 45 8, 70 5 C95 2, 115 8, 140 6 C160 4, 180 8, 198 5"
                :stroke="color"
                stroke-width="2.5"
                stroke-linecap="round"
                fill="none"
                vector-effect="non-scaling-stroke"
            />
        </svg>
    </span>
</template>
