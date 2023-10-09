<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2021
 * @license Webasyst
 */
declare(strict_types=1);

/**
 * Class shopDbcPluginSettingsSaveController
 */
class shopDbcPluginSettingsSaveController extends waJsonController
{
    /**
     * @return void
     * @throws waException
     */
    public function execute()
    {
        $settings = waRequest::post('settings', null, waRequest::TYPE_STRING_TRIM);
        $settings = waUtils::jsonDecode($settings, true);
        wa('shop')->getPlugin('dbc')->saveSettings($settings);
        $this->response = ['message' => 'Сохранено'];
    }
}
