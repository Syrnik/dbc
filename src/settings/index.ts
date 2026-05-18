import { createApp } from 'vue'
import App from './AppUi2.vue'
import type { PluginInfo, PluginSettings, I18n } from '../types'

const ShopDbcPluginSettings = (props: { info: PluginInfo; settings: PluginSettings; i18n: I18n }) =>
    createApp(App, props)

export default ShopDbcPluginSettings
