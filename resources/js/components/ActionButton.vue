<template>
    <button class="w-9 h-9 flex items-center justify-center rounded-full" :class="bgColor[color]"
        @click="$emit('click')">
        <component :is="icon" class="w-5 h-5 text-white" />
    </button>
</template>

<script setup>
const props = defineProps({
    icon: Object,
    color: {
        type: String,
        default: 'orange'
    }
})

const bgColor = {
    orange: 'bg-[#FF7D3F]',
    red: 'bg-red-500',
    green: 'bg-green-500',
    grey: 'bg-[#cccccc]'
}
</script>
