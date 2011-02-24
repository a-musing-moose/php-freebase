<?php
/**
 * @package
 * @copyright 2010 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * Description of Transport
 *
 * @package
 */
class Transport
{

    private $baseUrl;
    
    /**
     * @param string $baseUrl 
     */
    public function __construct($baseUrl)
    {
        if (\substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }
        $this->baseUrl = $baseUrl;
    }

    public function query($uri)
    {
        $url = $this->baseUrl . $uri;
        $json = \file_get_contents($url);
        return Factory::loadFromJson($json);
    }

}