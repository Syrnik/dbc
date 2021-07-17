import Vue from 'vue'
import App from './App.vue'
import WaField from '../vue-components/wa-field.vue'

Vue.component("WaField", WaField);

export default function (options) {
    options = options || {};
    const s = new Vue({
        el: options.el,
        render(h) {
            return h(App, {props: {info: options.info || {}, settings: options.settings || {}}})
        }
    })
}
