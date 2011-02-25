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
    /**
     * @var string
     */
    private $baseFetchUrl;

    /**
     * @var string
     */
    private $baseApiUrl;
    
    /**
     * @param string $baseUrl 
     */
    public function __construct($baseFetchUrl = "http://www.freebase.com/experimental/topic/standard/", $baseApiUrl = "http://api.freebase.com/api/service/")
    {
        if (\substr($baseFetchUrl, -1) !== '/') {
            $baseFetchUrl .= '/';
        }
        $this->baseFetchUrl = $baseFetchUrl;

        if (\substr($baseApiUrl, -1) !== '/') {
            $baseApiUrl .= '/';
        }
        $this->baseApiUrl = $baseApiUrl;
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
        $json = $this->doRequest($url);
        return DomFactory::createDomFromJson($json);
    }

    /**
     * @param Query $query
     * @return \freebase\Node
     */
    public function fetchByQuery(Query $query)
    {
        $url = $this->baseApiUrl . 'mqlread';
        $json = $this->doRequest($url, $query->__toJson());
        return DomFactory::createDomFromJson($json);
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
            \curl_setopt($ch, \CURLOPT_POSTFIELDS, array('query' => $jsonData));
        }
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }

}