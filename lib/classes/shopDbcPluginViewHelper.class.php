<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2022
 * @license Webasyst
 */
declare(strict_types=1);

/**
 * @Helper
 */
class shopDbcPluginViewHelper extends waPluginViewHelper
{
    static protected $cost_cache = [];

    /**
     * @HelperMethod
     *
     * @param int|string|array|shopOrder $order
     * @return float|null
     */
    public function shippingCost($order): ?float
    {
        if (is_string($order)) $order = (int)$order;
        if (is_int($order) && $order) return $this->getCostFromDb($order);
        if ($order instanceof shopOrder) return $this->getCostFromShopOrder($order);
        if (is_array($order) && ($order['params'] ?? false)) {
            $cost = $order['params']['plugin_dbc.shipping'] ?? null;
            if ($cost !== null) $cost = floatval($cost);
            if ($order['id'] ?? false) self::$cost_cache[(int)$order['id']] = $cost;
            return $cost;
        }

        return null;
    }

    /**
     * @param $order
     * @return float|null
     */
    protected function getCostFromDb($order): ?float
    {
        if (array_key_exists($order, self::$cost_cache))
            return self::$cost_cache[$order];
        $cost = (new shopOrderParamsModel())->getOne($order, 'plugin_dbc.shipping');
        $cost = $cost === null ? $cost : floatval($cost);
        self::$cost_cache[$order] = $cost;
        return $cost;
    }

    /**
     * @param shopOrder $order
     * @return float|mixed|string|null
     */
    protected function getCostFromShopOrder(shopOrder $order)
    {
        $params = $order->params;
        $cost = $params['plugin_dbc.shipping'] ?? null;
        if ($cost !== null) $cost = floatval($cost);
        self::$cost_cache[(int)$order->id] = $cost;
        return $cost;
    }
}
