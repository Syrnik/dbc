<script setup lang="ts">
import { reactive } from 'vue'
import type { PluginInfo, PluginSettings } from '../types'
import MethodsUi2 from './components/MethodsUi2.vue'
import WaSubmitField from '../components/WaSubmitField.vue'

const props = defineProps<{ info: PluginInfo; settings: PluginSettings }>()
const setting = reactive({ ...props.settings })
</script>

<template>
    <form class="fields">
        <MethodsUi2
            name="Способы доставки"
            :methods="info.shipping_methods"
            methods_type="доставки"
            v-model="setting.shipping"
        />
        <MethodsUi2
            name="Способы оплаты"
            :methods="info.payment_methods"
            methods_type="оплаты"
            v-model="setting.payment"
        />
        <WaSubmitField
            :settings="setting"
            url="?plugin=dbc&module=settings&action=save"
            :icon-class="{ success: 'icon16 yes' }"
        />
    </form>
</template>
