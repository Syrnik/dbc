<script setup lang="ts">
defineProps<{ name?: string }>()
</script>

<template>
    <div class="field">
        <div class="name" v-if="name?.length" v-html="name"></div>
        <slot />
    </div>
</template>
