<?php
/**
 * Raisely Webhooks for Craft CMS 3.x.
 *
 * Handles Raisely's Webhooks in CraftCMS
 *
 * @email dgonzalezad@gmail.com
 * @copyright Copyright (c) 2020 Daniel G Adarve
 */

namespace danieladarve\raiselywebhooks;

use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use danieladarve\raiselywebhooks\models\Settings;

use yii\base\Event;

/**
 * Class RaiselyWebhooks.
 *
 * @author    Daniel G Adarve
 * @package   RaiselyWebhooks
 * @since     1.0.0
 *
 */
class RaiselyWebhooks extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var RaiselyWebhooks
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules[$this->settings->endpoint] = 'raisely-webhooks/default';
            }
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }
}
