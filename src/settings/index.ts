import { createApp } from 'vue'
import App from './AppUi2.vue'
import type { PluginInfo, PluginSettings } from '../types'

const ShopDbcPluginSettings = (props: { info: PluginInfo; settings: PluginSettings }) =>
    createApp(App, props)

export default ShopDbcPluginSettings
