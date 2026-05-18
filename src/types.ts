export interface ShippingPaymentMethod {
    id: number
    name: string
    shop_enabled: boolean
    unknown?: boolean
}

export interface MethodSetting {
    id: number
    enabled: boolean
}

export interface SettingGroup {
    all: boolean
    selected: MethodSetting[]
}

export interface PluginSettings {
    shipping: SettingGroup
    payment: SettingGroup
}

export interface PluginInfo {
    shipping_methods: ShippingPaymentMethod[]
    payment_methods: ShippingPaymentMethod[]
    plugin_name: string
    plugin_version: string
}
