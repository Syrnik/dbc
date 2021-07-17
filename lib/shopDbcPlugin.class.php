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
        if (!$this->typecasted_settings) $this->typecastSettings(parent::getSettings());

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

        $selected_shipping = false;
        if (!$shipping_methods['all'])
            foreach ($shipping_methods['selected'] as $m) {
                if ($m['id'] === $shipping_id) {
                    $selected_shipping = $m['enabled'];
                    break;
                }
            }
        else $selected_shipping = true;

        $selected_payment = false;
        if (!$payment_methods['all'])
            foreach ($payment_methods['selected'] as $m) {
                if ($m['id'] === $payment_id) {
                    $selected_payment = $m['enabled'];
                    break;
                }
            }
        else $selected_payment = true;

        $shipping = $shipping_methods['all'] || $selected_shipping;
        $payment = $payment_methods['all'] || $selected_payment;

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

    /**
     * Обработчик хука созания/редактирования заказа
     *
     * @param $data
     */
    public function handlerOrderAction($data)
    {
        if (!($order_id = intval($data['order_id'] ?? 0))) return;

        $OrderParams = new shopOrderParamsModel();
        try {
            $params = $OrderParams->query(
                "SELECT name, value FROM `shop_order_params` WHERE order_id=i:order_id AND name IN ('shipping_id', 'payment_id', 'plugin_dbc.shipping')",
                ['order_id' => $order_id]
            )->fetchAll('name', true);
        } catch (waDbException $e) {
            return;
        }

        if (!$params || !is_array($params)) return;
        if (!($shipping_id = intval($params['shipping_id'] ?? 0))) return;
        if (!($payment_id = intval($params['payment_id'] ?? 0))) return;

        if (!$this->isNullifyRequired($shipping_id, $payment_id)) {
            if (isset($params['plugin_dbc.shipping'])) {
                $OrderParams->deleteByField(['order_id' => $order_id, 'name' => 'plugin_dbc.shipping']);
            }
            return;
        }

        $old_dbc_value = $params['plugin_dbc.shipping'] ?? null;
        $ShopOrder = new shopOrderModel();
        try {
            $shipping = $ShopOrder->query("SELECT shipping FROM `shop_order` WHERE id=i:id", ['id' => $order_id])->fetchField();
        } catch (waDbException $e) {
            return;
        }
        if (!$shipping) return;

        $new_dbc_value = (float)$shipping;
        $new_dbc_value_str = number_format($new_dbc_value, 4, '.', '');

        $ShopOrder->updateById($order_id, ['shipping' => 0.0]);
        try {
            $OrderParams->exec(
                "INSERT INTO `shop_order_params` (order_id, name, value) VALUES (i:order_id, 'plugin_dbc.shipping', s:value) ON DUPLICATE KEY UPDATE value=s:value",
                ['order_id' => $order_id, 'value' => $new_dbc_value_str]
            );
        }catch (Exception $e) {
            return;
        }

        $log_message = sprintf("Стоимость доставки из заказа в размере <b>%s</b> заменена на 0 плагином 'Оплата доставки при получении'", $new_dbc_value_str);
        $after_state_id = $data['after_state_id'] ?? '';
        (new shopOrderLogModel())->insert([
            'order_id'        => $order_id,
            'contact_id'      => null,
            'action_id'       => '',
            'datetime'        => date("Y-m-d H:i:s"),
            'before_state_id' => $after_state_id,
            'after_state_id'  => $after_state_id,
            'text'            => $log_message
        ]);
    }
}
