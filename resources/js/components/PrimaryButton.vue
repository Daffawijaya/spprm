<template>
    <button @click="$emit('click')" :class="[
        'text-sm text-white px-4 py-1 rounded-full flex items-center justify-between gap-2',
        colorClass,
        block ? 'w-full' : ''
    ]">
        <slot />
        <slot name="icon" v-if="$slots.icon" />
    </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    color: { type: String, default: 'green' },
    block: { type: Boolean, default: false }
})

const colorClass = computed(() => {
    return {
        green: 'bg-[#ADDC8B]',
        red: 'bg-red-500',
        orange: 'bg-[#FF7D3F]'
    }[props.color] || 'bg-[#ADDC8B]'
})
</script>
