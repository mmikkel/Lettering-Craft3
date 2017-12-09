<?php
/**
 * Lettering plugin for Craft CMS 3.x
 *
 * Like Lettering.js, but in Twig
 *
 * @link      https://vaersaagod.no
 * @copyright Copyright (c) 2017 Mats Mikkel Rummelhoff
 */

namespace mmikkel\lettering\variables;

use mmikkel\lettering\Lettering;

class LetteringVariable
{
    // Public Methods
    // =========================================================================
    /**
     * @param $text
     * @return mixed
     */
    public function lettering($text)
    {
        return Lettering::$plugin->letteringService->chars($text);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function chars($text)
    {
        return Lettering::$plugin->letteringService->chars($text);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function words($text)
    {
        return Lettering::$plugin->letteringService->words($text);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function lines($text)
    {
        return Lettering::$plugin->letteringService->lines($text);
    }

}
