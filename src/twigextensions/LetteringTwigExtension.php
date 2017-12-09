<?php
/**
 * Lettering plugin for Craft CMS 3.x
 *
 * Like Lettering.js, but in Twig
 *
 * @link      https://vaersaagod.no
 * @copyright Copyright (c) 2017 Mats Mikkel Rummelhoff
 */

namespace mmikkel\lettering\twigextensions;

use mmikkel\lettering\Lettering;

use craft\helpers\Template;

class LetteringTwigExtension extends \Twig_Extension
{

    protected $encoding = 'UTF-8';

    /**
     * @return string
     */
    public function getName()
    {
        return 'Lettering';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('lettering', [$this, 'letteringFilter']),
        ];
    }

    public function letteringFilter($text = null, $method = 'chars')
    {

        $service = Lettering::$plugin->letteringService;

        if (!$text || strlen($text) === 0 || !method_exists($service, $method)) {
            return $text;
        }

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding('<div id="workingNode">' . $text . '</div>', 'HTML-ENTITIES', $this->encoding));
        $workingNode = $dom->getElementById('workingNode');

        $fragment = $dom->createDocumentFragment();
        foreach ($workingNode->childNodes as $node) {

            if ($node->nodeType !== 1) {
                continue;
            }

            $value = $node->nodeValue;
            $result = $service->$method($value, $method);
            $node->nodeValue = '';

            $tempFragment = new \DOMDocument();
            $tempFragment->loadHTML(mb_convert_encoding($result[$method], 'HTML-ENTITIES', $this->encoding));

            foreach ($tempFragment->getElementsByTagName('body')->item(0)->childNodes as $tempNode) {
                $tempNode = $node->ownerDocument->importNode($tempNode, true);
                $node->appendChild($tempNode);
            }
            $node->setAttribute('aria-label', trim(strip_tags($value)));
            $fragment->appendChild($node->cloneNode(true));
        }

        $workingNode->parentNode->replaceChild($fragment, $workingNode);
        $result = Template::raw(preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $dom->saveHTML()));

        if (strlen(trim($result)) === 0) {
            $result = $service->$method($text);
            return $result ? $result[$method] : $text;
        }

        libxml_use_internal_errors(false);

        return $result;
    }

    /**
     * @return array|\Twig_Filter[]|\Twig_SimpleFilter[]
     */
    /*public function getFilters()
    {
        return array_map(function ($method) {
            return new \Twig_SimpleFilter('retcon' . ($method != 'retcon' ? ucfirst($method) : ''), array('mmikkel\retcon\library\RetconApi', $method));
        }, get_class_methods('mmikkel\retcon\library\RetconApi'));
    }*/
}
