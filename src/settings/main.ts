import { createApp } from 'vue'
import App from './App.vue'
import type { PluginInfo, PluginSettings } from '../types'

declare global {
    interface Window {
        ShopDbcPluginSettings: (options: { el: string; info: PluginInfo; settings: PluginSettings }) => void
    }
}

window.ShopDbcPluginSettings = function (options) {
    createApp(App, {
        info: options.info ?? {},
        settings: options.settings ?? {},
    }).mount(options.el)
}
