<template>
  <form>
    <div class="field-group">
      <methods name="Способы доставки" :methods="info.shipping_methods" methods_type="доставки"
               v-model="setting.shipping"></methods>
    </div>
    <div class="field-group">
      <methods name="Способы оплаты" :methods="info.payment_methods" methods_type="оплаты" v-model="settings.payment"/>
    </div>
    <wa-submit-field :settings="setting" url="?plugin=dbc&module=settings&action=save"
                     :icon-class="{success: 'icon16 yes'}"/>
  </form>
</template>

<script>
import Methods from "./methods.vue";
import WaSubmitField from "../vue-components/wa-submit-field.vue";

export default {
  components: {WaSubmitField, Methods},
  props: ['info', 'settings'],
  data() {
    return {
      setting: this.settings
    }
  }
}
</script>
