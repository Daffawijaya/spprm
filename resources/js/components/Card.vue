<template>
    <div class="space-y-2">
        <div v-if="$slots.header" class="text-xl font-semibold">
            <slot name="header"></slot>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden py-8 gap-y-4 space-y-4">

            <!-- Main content slot -->
            <div class="px-8">
                <slot></slot>
            </div>

            <div v-if="$slots.table">
                <slot name="table"></slot>
            </div>

            <!-- Footer slot -->
            <div v-if="$slots.footer" class="px-8">
                <slot name="footer"></slot>

            </div>
        </div>
    </div>
    <!-- Header slot -->

</template>

<script>
export default {
    name: 'Card',
}
</script>
