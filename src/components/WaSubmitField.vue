<script setup lang="ts">
import { ref, computed } from 'vue'
import WaFieldSimple from './WaFieldSimple.vue'

declare const $: any

const props = withDefaults(defineProps<{
    settings: object
    url: string
    label: string
    allowed?: boolean
    iconClass?: Record<string, string | string[]>
}>(), {
    allowed: true,
})

const emit = defineEmits<{ (e: 'submitting', value: boolean): void }>()

const statusMsg = ref('')
const status = ref('')
const running = ref(false)

const statusClass = computed(() => {
    if (status.value === 'success') return ['success', 'successmsg']
    return []
})

const statusIconClass = computed(() => {
    switch (status.value) {
        case 'loading': return props.iconClass?.loading ?? ['icon16', 'loading']
        case 'success': return props.iconClass?.success ?? ['fas', 'fa-check']
    }
})

const buttonDisabled = computed(() => running.value || props.allowed === false)

function save() {
    status.value = 'loading'
    running.value = true
    emit('submitting', true)
    $.shop.jsonPost(
        props.url,
        { settings: JSON.stringify(props.settings) },
        (r: { data?: { message?: string } }) => {
            if (r.data?.message) {
                statusMsg.value = r.data.message
                status.value = 'success'
                setTimeout(() => {
                    status.value = ''
                    statusMsg.value = ''
                }, 5000)
            }
        },
    ).always(() => {
        running.value = false
        emit('submitting', false)
    })
}
</script>

<template>
    <WaFieldSimple :value-class="[{ submit: true }, statusClass]">
        <button class="green button" type="button" @click="save" :disabled="buttonDisabled">{{ label }}</button>
        <span v-show="status.length">
            <i :class="statusIconClass" v-if="status.length"></i>
            {{ statusMsg }}
        </span>
    </WaFieldSimple>
</template>
