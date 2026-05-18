<script setup lang="ts">
import { reactive } from 'vue'
import type { SettingGroup, ShippingPaymentMethod, MethodGroupI18n } from '../../types'
import MethodItem from './MethodItem.vue'
import WaField from '../../components/WaField.vue'

const props = defineProps<{
    modelValue: SettingGroup
    i18n: MethodGroupI18n
    unknownMethod: string
    methods: ShippingPaymentMethod[]
}>()
const emit = defineEmits<{ (e: 'update:modelValue', value: SettingGroup): void }>()

const setting = reactive({ ...props.modelValue })
</script>

<template>
    <WaField :name="i18n.name">
        <div class="value">
            <label>
                <input type="checkbox" v-model="setting.all" @change="emit('update:modelValue', setting)">
                &mdash; {{ i18n.any }}
            </label>
        </div>
        <div v-show="!setting.all">
            <div class="value" style="margin-top: 1em">
                {{ i18n.hint }}
            </div>
            <MethodItem
                v-for="(m, idx) in setting.selected"
                :key="m.id"
                :method="methods.find(me => me.id === m.id)"
                :model-value="setting.selected[idx]"
                :unknown-method="unknownMethod"
                @update:model-value="(val) => { setting.selected[idx] = val; emit('update:modelValue', setting) }"
            />
        </div>
    </WaField>
</template>
