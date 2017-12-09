<?php
/**
 * Lettering plugin for Craft CMS 3.x
 *
 * Like Lettering.js, but in Twig
 *
 * @link      https://vaersaagod.no
 * @copyright Copyright (c) 2017 Mats Mikkel Rummelhoff
 */

namespace mmikkel\lettering;

use mmikkel\lettering\twigextensions\LetteringTwigExtension;
use mmikkel\lettering\variables\LetteringVariable;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class Lettering
 *
 * @author    Mats Mikkel Rummelhoff
 * @package   Lettering
 * @since     1.0.0
 *
 */
class Lettering extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Lettering
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register the Lettering service
        $this->setComponents([
            'letteringService' => \mmikkel\lettering\services\LetteringService::class,
        ]);

        // Add in our Twig extensions
        Craft::$app->view->registerTwigExtension(new LetteringTwigExtension());

        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('lettering', LetteringVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'lettering',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
