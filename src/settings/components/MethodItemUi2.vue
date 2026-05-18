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

const nameClass = computed(() => ({
    'hint': !shopMethod.value.shop_enabled,
    'line-through': shopMethod.value.unknown,
}))
</script>

<template>
    <li>
        <label>
            <span class="wa-checkbox">
                <input type="checkbox" v-model="setting.enabled" @change="emit('update:modelValue', setting)">
                <span><span class="icon"><i class="fas fa-check"></i></span></span>
            </span>
            &mdash; <span :class="nameClass">{{ shopMethod.name }}</span>
        </label>
    </li>
</template>
