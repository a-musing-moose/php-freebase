<?php
/**
 * @package freebase
 * @copyright 2011 Tangent One
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * Master interface class to freebase
 *
 * @package freebase
 */
class Freebase
{

    private $baseFetchUrl;

    private $baseSearchUrl;
    
    /**
     * @param string $baseUrl 
     */
    public function __construct($baseFetchUrl, $baseSearchUrl)
    {
        if (\substr($baseFetchUrl, -1) !== '/') {
            $baseFetchUrl .= '/';
        }
        $this->baseFetchUrl = $baseFetchUrl;

        if (\substr($baseSearchUrl, -1) !== '/') {
            $baseSearchUrl .= '/';
        }
        $this->baseSearchUrl = $baseSearchUrl;
    }

    /**
     * @param string $id
     * @return \freebase\Node
     */
    public function fetchById($id)
    {
        if (\substr($id, 0, 1) === '/') {
            $id = \substr($id, 1); //strip first / if needed as already insured in constructor
        }
        $url = $this->baseFetchUrl . $id;
        $json = \file_get_contents($url);
        return DomFactory::createDomFromJson($json);
    }

    public function fetchByQuery(Query $query)
    {

    }

    /**
     * @param string $url
     * @param string $jsonData
     * @return string
     */
    protected function doRequest($url, $jsonData = null)
    {
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        if (null !== $jsonData) {
            \curl_setopt($ch, \CURLOPT_POST, true);
            \curl_setopt($ch, \CURLOPT_POSTFIELDS, $jsonData);
        }
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }

}