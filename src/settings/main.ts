import { createApp } from 'vue'
import App from './App.vue'
import type { PluginInfo, PluginSettings, I18n } from '../types'

declare global {
    interface Window {
        ShopDbcPluginSettings: (options: { el: string; info: PluginInfo; settings: PluginSettings; i18n: I18n }) => void
    }
}

window.ShopDbcPluginSettings = function (options) {
    createApp(App, {
        info: options.info ?? {},
        settings: options.settings ?? {},
        i18n: options.i18n ?? {},
    }).mount(options.el)
}
