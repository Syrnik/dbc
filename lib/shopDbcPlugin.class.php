<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2021
 * @license Webasyst
 */
declare(strict_types=1);

/**
 * Main plugin class
 */
class shopDbcPlugin extends shopPlugin
{
    protected $typecasted_settings;

    /**
     * @param null|string|int $name
     * @return array|mixed|null
     */
    public function getSettings($name = null)
    {
        if (!$this->typecasted_settings) $this->typecastSettings(parent::getSettings($name));

        if ($name === null) return $this->typecasted_settings;

        return $this->typecasted_settings[$name] ?? null;
    }

    /**
     * Нужно ли обнулять доставку для выбранных способов доставки и оплаты
     *
     * @param int $shipping_id
     * @param int $payment_id
     * @return bool
     */
    public function isNullifyRequired(int $shipping_id, int $payment_id): bool
    {
        $shipping_methods = $this->getSettings('shipping');
        $payment_methods = $this->getSettings('payment');

        if ($shipping_methods['all'] && $payment_methods['all']) return true;

        $selected_shipping = array_column($shipping_methods['selected'], 'enabled', 'id');
        $selected_payment = array_column($shipping_methods['selected'], 'enabled', 'id');

        $shipping = $shipping_methods['all'] || (isset($selected_shipping[$shipping_id]) && $selected_shipping['id']);
        $payment = $payment_methods['all'] || (isset($selected_payment[$shipping_id]) && $selected_payment['id']);

        return $shipping && $payment;
    }

    /**
     * @param array $settings
     * @return array
     */
    protected function typecastSettings(array $settings): array
    {
        if ($this->typecasted_settings) return $this->typecasted_settings;

        foreach ($settings as $key => $setting) {
            switch ($key) {
                case 'shipping':
                case 'payment':
                    $setting = (array)$setting;
                    $setting['all'] = boolval($setting['all'] ?? false);
                    $setting['selected'] = $setting['selected'] ?? [];
                    if (!$setting['all']) {
                        foreach ($setting['selected'] as &$item) {
                            $item['id'] = (int)$item['id'];
                            $item['enabled'] = (bool)$item['enabled'];
                        }
                        unset($item);
                    }
                    break;
            }
            $settings[$key] = $setting;
        }

        $this->typecasted_settings = $settings;

        return $this->typecasted_settings;
    }
}
