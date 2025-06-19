<template>
    <button class="w-8 h-8 flex items-center justify-center rounded-full" :class="bgColor[color]"
        @click="$emit('click')">
        <component :is="icon" class="w-4 h-4 text-white" />
    </button>
</template>

<script setup>
const props = defineProps({
    icon: Object,
    color: {
        type: String,
        default: 'bg-[#cccccc]'
    }
})

const bgColor = {
    orange: 'bg-[#FF7D3F]',
    red: 'bg-red-500',
    grey: 'bg-[#cccccc]'
}
</script>
