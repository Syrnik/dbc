<script setup lang="ts">
import { reactive } from 'vue'
import type { PluginInfo, PluginSettings } from '../types'
import Methods from './components/Methods.vue'
import WaSubmitField from '../components/WaSubmitField.vue'

const props = defineProps<{ info: PluginInfo; settings: PluginSettings }>()
const setting = reactive({ ...props.settings })
</script>

<template>
    <form>
        <div class="field-group">
            <Methods
                name="Способы доставки"
                :methods="info.shipping_methods"
                methods_type="доставки"
                v-model="setting.shipping"
            />
        </div>
        <div class="field-group">
            <Methods
                name="Способы оплаты"
                :methods="info.payment_methods"
                methods_type="оплаты"
                v-model="setting.payment"
            />
        </div>
        <WaSubmitField
            :settings="setting"
            url="?plugin=dbc&module=settings&action=save"
            :icon-class="{ success: 'icon16 yes' }"
        />
    </form>
</template>
