<script setup lang="ts">
import { reactive, computed } from 'vue'
import type { MethodSetting, ShippingPaymentMethod } from '../../types'

const props = defineProps<{
    modelValue: MethodSetting
    method?: ShippingPaymentMethod
}>()
const emit = defineEmits<{ (e: 'update:modelValue', value: MethodSetting): void }>()

const setting = reactive({ ...props.modelValue })

const shopMethod = computed(() => props.method ?? {
    id: setting.id,
    name: 'Неизвестный или удалённый способ',
    shop_enabled: false,
    unknown: true,
})

const nameStyle = computed(() => {
    const style: Record<string, string> = {}
    if (!shopMethod.value.shop_enabled) style.color = '#777'
    if (shopMethod.value.unknown) style['text-decoration'] = 'line-through'
    return style
})
</script>

<template>
    <div class="value">
        <label>
            <input type="checkbox" v-model="setting.enabled" @change="emit('update:modelValue', setting)">
            &mdash; <span :style="nameStyle">{{ shopMethod.name }}</span>
        </label>
    </div>
</template>
