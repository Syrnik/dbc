<template>
  <div class="value">
    <label><input type="checkbox" @change="$emit('input', setting)" v-model="setting.enabled"> &mdash; <span
        :style="nameStyle">{{
        shop_method.name
      }}</span></label>
  </div>
</template>

<script>
export default {
  props: ['value', 'method'],
  data() {
    return {
      setting: this.value
    }
  },
  computed: {
    shop_method() {
      return typeof this.method === 'object' ? this.method : {
        id: this.setting.id,
        name: 'Неизвестный или удалённый способ',
        shop_enabled: false,
        unknown: true
      }
    },
    nameStyle() {
      const style = {};
      if (!this.shop_method.shop_enabled) style.color = '#777';
      if (this.shop_method.unknown) style['text-decoration'] = 'line-through';
      return style;
    }
  }
}
</script>
