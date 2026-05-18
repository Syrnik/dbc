<script setup lang="ts">
import { reactive } from 'vue'
import type { SettingGroup, ShippingPaymentMethod, MethodGroupI18n } from '../../types'
import MethodItemUi2 from './MethodItemUi2.vue'
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
                <span class="wa-checkbox">
                    <input type="checkbox" v-model="setting.all" @change="emit('update:modelValue', setting)">
                    <span><span class="icon"><i class="fas fa-check"></i></span></span>
                </span>
                &mdash; {{ i18n.any }}
            </label>
            <ul v-show="!setting.all">
                <li class="hint">{{ i18n.hint }}</li>
                <MethodItemUi2
                    v-for="(m, idx) in setting.selected"
                    :key="m.id"
                    :method="methods.find(me => me.id === m.id)"
                    :model-value="setting.selected[idx]"
                    :unknown-method="unknownMethod"
                    @update:model-value="(val) => { setting.selected[idx] = val; emit('update:modelValue', setting) }"
                />
            </ul>
        </div>
    </WaField>
</template>
