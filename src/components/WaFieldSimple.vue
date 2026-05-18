<script setup lang="ts">
import WaField from './WaField.vue'

defineProps<{ name?: string; valueClass?: string | Record<string, boolean> | unknown[] }>()
</script>

<template>
    <WaField :name="name">
        <div class="value" :class="valueClass"><slot /></div>
    </WaField>
</template>
