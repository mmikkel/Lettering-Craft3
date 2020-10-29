<?php
/**
 * Lettering plugin for Craft CMS 3.x
 *
 * Like Lettering.js, but in Twig
 *
 * @link      https://vaersaagod.no
 * @copyright Copyright (c) 2017 Mats Mikkel Rummelhoff
 */

namespace mmikkel\lettering\services;

use craft\base\Component;
use craft\helpers\Template;
use craft\helpers\StringHelper;
use craft\helpers\ArrayHelper;

class LetteringService extends Component
{

    /**
     * @param $text
     * @return array
     */
    public function chars($text) {
        return $this->injector($text);
    }

    /**
     * @param $text
     * @return array
     */
    public function words($text) {
        return $this->injector($text, 'words', ' ');
    }

    /**
     * @param $text
     * @return array
     */
    public function lines($text) {
        return $this->injector($text, 'lines', ' ');
    }

    /**
     * @param $text
     * @param string $class
     * @param string $after
     * @return array
     */
    protected function injector($text, $class = 'chars', $after = '') {

        $text = \trim($text);

        switch ($class) {
            case 'words' :
                $parts = $this->_splitWords(StringHelper::stripHtml($text));
                break;
            case 'lines' :
                $parts = StringHelper::lines(StringHelper::stripHtml($text));
                break;
            default :
                $parts = StringHelper::charsAsArray(StringHelper::stripHtml($text), '');
                break;
        }

        $count = 1;

        $formattedParts = array_map(function($part) use (&$count, $class, $after) {
            $part = '<span class="'.substr($class, 0, -1) . $count . '" aria-hidden="true">' . $part . '</span>' . $after;
            $count = $count + 1;
            return $part;
        }, \array_filter($parts));

        $ariaLabel = Template::raw(' aria-label="'. StringHelper::collapseWhitespace(trim(strip_tags($text))) .'"');
        $joined = Template::raw( implode('', $formattedParts) );

        $result = [
            'original' => $text,
            'ariaLabel' => $ariaLabel,
            $class => $joined,
        ];

        return $result;
    }
	 
    /**
     * Overriding the splitWords function from StringHelper
     * @param $str
     * @return array
     */
    private function _splitWords($str): array {
        // Split on any character or punctuation
        // Reference: http://www.regular-expressions.info/unicode.html
        preg_match_all('/[^\p{Z}]+/u', $str, $matches);

        return ArrayHelper::filterEmptyStringsFromArray($matches[0]);
    }
}
