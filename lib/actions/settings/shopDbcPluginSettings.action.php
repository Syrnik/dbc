<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2021
 * @license Webasyst
 */
declare(strict_types=1);

/**
 * Class shopDbcPluginSettingsAction
 */
class shopDbcPluginSettingsAction extends waViewAction
{
    public function execute()
    {
        /** @var shopDbcPlugin $plugin */
        $plugin = wa('shop')->getPlugin('dbc');

        $info = [
            'plugin_name'    => $plugin->getName(),
            'plugin_version' => $plugin->getVersion(),
        ];

        $settings = $plugin->getSettings();
        $settings['payment'] = $this->actualizeSelected($settings['payment'], $this->listMethods('payment'));
        $settings['shipping'] = $this->actualizeSelected($settings['shipping'], $this->listMethods('shipping'));

        $this->view->assign(compact('info', 'settings'));
    }

    /**
     * Список методов доставки или оплаты в магазине
     *
     * @param string $type 'shipping' или 'payment'
     * @return array
     * @throws waException
     */
    protected function listMethods(string $type): array
    {
        $methods = array_values((new shopPluginModel)->listPlugins($type, ['all' => true]));

        return array_map(function ($m) {
            return [
                'id'           => (int)$m['id'],
                'name'         => (string)$m['name'],
                'shop_enabled' => (bool)$m['status']
            ];
        }, $methods);
    }

    /**
     * Актуализируем настройку выбранных методов -- добавляем новые, убираем удалённые
     *
     * @param array $setting
     * @param array $methods
     * @return array
     */
    protected function actualizeSelected(array $setting, array $methods): array
    {
        $methods = array_column($methods, 'id', 'id');

        foreach ($setting['selected'] as $index => $item) {
            if (isset($methods[$item['id']])) {
                unset($methods['id']);
                continue;
            };
            unset($setting['selected'][$index]);
        }

        if ($methods) {
            foreach ($methods as $method) {
                $setting['selected'][] = ['id' => $method, 'enabled' => false];
            }
        }

        $setting['selected'] = array_values($setting['selected']);

        return $setting;
    }
}
