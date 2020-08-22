<?php

class HTMLPurifier_Filter_YouKu extends HTMLPurifier_Filter
{

    /**
     * @type string
     */
    public $name = 'YouKu';

    /**
     * @param string $html
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return string
     */
    public function preFilter($html, $config, $context)
    {
        $pre_regex = '#<object[^>]+>.+?' .
            '(?:http:)?//www.youku.com/((?:v|cp)/[A-Za-z0-9\-_=]+).+?</object>#s';
        $pre_replace = '<span class="youku-embed">\1</span>';
        return preg_replace($pre_regex, $pre_replace, $html);
    }

    /**
     * @param string $html
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return string
     */
    public function postFilter($html, $config, $context)
    {
        $post_regex = '#<span class="youku-embed">((?:v|cp)/[A-Za-z0-9\-_=]+)</span>#';
        return preg_replace_callback($post_regex, array($this, 'postFilterCallback'), $html);
    }

    /**
     * @param $url
     * @return string
     */
    protected function armorUrl($url)
    {
        return str_replace('--', '-&#45;', $url);
    }

    /**
     * @param array $matches
     * @return string
     */
    protected function postFilterCallback($matches)
    {
        $url = $this->armorUrl($matches[1]);
        return '<object width="425" height="350" type="application/x-shockwave-flash" ' .
        'data="//www.youku.com/' . $url . '">' .
        '<param name="movie" value="//www.youku.com/' . $url . '"></param>' .
        '<!--[if IE]>' .
        '<embed src="//www.youku.com/' . $url . '"' .
        'type="application/x-shockwave-flash"' .
        'wmode="transparent" width="425" height="350" />' .
        '<![endif]-->' .
        '</object>';
    }
}

// vim: et sw=4 sts=4
