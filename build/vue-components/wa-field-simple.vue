<template>
    <wa-field :name="name">
        <div class="value" :class="valueClass"><slot /></div>
    </wa-field>
</template>

<script>
    import waField from './wa-field.vue'

    export default {
        props: {name: {default: ''}, valueClass: {default: ''}},
        components: { waField }
    }
</script>
