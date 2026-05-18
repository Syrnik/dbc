<script setup lang="ts">
import { reactive } from 'vue'
import type { PluginInfo, PluginSettings, I18n } from '../types'
import MethodsUi2 from './components/MethodsUi2.vue'
import WaSubmitField from '../components/WaSubmitField.vue'

const props = defineProps<{ info: PluginInfo; settings: PluginSettings; i18n: I18n }>()
const setting = reactive({ ...props.settings })
</script>

<template>
    <form class="fields">
        <MethodsUi2
            :i18n="i18n.shipping"
            :unknown-method="i18n.unknown_method"
            :methods="info.shipping_methods"
            v-model="setting.shipping"
        />
        <MethodsUi2
            :i18n="i18n.payment"
            :unknown-method="i18n.unknown_method"
            :methods="info.payment_methods"
            v-model="setting.payment"
        />
        <WaSubmitField
            :settings="setting"
            url="?plugin=dbc&module=settings&action=save"
            :label="i18n.save"
            :icon-class="{ success: 'icon16 yes' }"
        />
    </form>
</template>
