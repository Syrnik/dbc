<template>
  <wa-field :name="name">
    <div class="value">
      <label><input type="checkbox" v-model="setting.all" @change="$emit('input', setting)"> &mdash; любые способы
        {{ methods_type }}</label>
    </div>
    <div v-show="!setting.all">
      <div class="value" style="margin-top: 1em">
        Выберите способы {{ methods_type }}, для которых должен срабатывать плагин. Если не выбрать ни одного, плагин
        отключится
      </div>
      <method-item v-for="(m,idx) in setting.selected" :key="m.id" :method="methods.find(me=>me.id===m.id)"
                   v-model="setting.selected[idx]"
                   @input="$emit('input', setting)"></method-item>
    </div>
  </wa-field>
</template>

<script>
import MethodItem from "./MethodItem.vue";

export default {
  components: {MethodItem},
  props: ['value', 'name', 'methods_type', 'methods'],
  data() {
    return {
      setting: this.value
    }
  }
}
</script>

