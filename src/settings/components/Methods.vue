<script setup lang="ts">
import { reactive } from 'vue'
import type { SettingGroup, ShippingPaymentMethod } from '../../types'
import MethodItem from './MethodItem.vue'
import WaField from '../../components/WaField.vue'

const props = defineProps<{
    modelValue: SettingGroup
    name: string
    methods_type: string
    methods: ShippingPaymentMethod[]
}>()
const emit = defineEmits<{ (e: 'update:modelValue', value: SettingGroup): void }>()

const setting = reactive({ ...props.modelValue })
</script>

<template>
    <WaField :name="name">
        <div class="value">
            <label>
                <input type="checkbox" v-model="setting.all" @change="emit('update:modelValue', setting)">
                &mdash; любые способы {{ methods_type }}
            </label>
        </div>
        <div v-show="!setting.all">
            <div class="value" style="margin-top: 1em">
                Выберите способы {{ methods_type }}, для которых должен срабатывать плагин.
                Если не выбрать ни одного, плагин отключится
            </div>
            <MethodItem
                v-for="(m, idx) in setting.selected"
                :key="m.id"
                :method="methods.find(me => me.id === m.id)"
                :model-value="setting.selected[idx]"
                @update:model-value="(val) => { setting.selected[idx] = val; emit('update:modelValue', setting) }"
            />
        </div>
    </WaField>
</template>
