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
