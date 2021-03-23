<?php
/**
 * commerce-afterpay-v3 plugin for Craft CMS 3.x
 *
 * Adds Afterpay V3 support to Craft Commerce
 *
 * @link      wndr.digital
 * @copyright Copyright (c) 2021 lenvanessen
 */

namespace wndr\commerce\afterpay;

use craft\base\Plugin;
use craft\commerce\services\Gateways;
use craft\events\RegisterComponentTypesEvent;
use wndr\commerce\afterpay\gateways\Gateway;
use yii\base\Event;

/**
 * Class Afterpay
 *
 * @author    lenvanessen
 * @package   Commerceafterpayv3
 * @since     1.0.0
 *
 */
class Afterpay extends Plugin
{
    /**
     * @var Afterpay
     */
    public static $plugin;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->_registerGateway();
    }

    private function _registerGateway()
    {
        Event::on(
            Gateways::class,
            Gateways::EVENT_REGISTER_GATEWAY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = Gateway::class;
            });
    }

}
