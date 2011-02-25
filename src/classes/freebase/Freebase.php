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

    const PATH_TOPIC = 'experimental/topic/standard/';

    const PATH_MQLREAD = 'service/mqlread';

    /**
     * @var string
     */
    private $baseUrl;
    
    /**
     * @param string $baseUrl 
     */
    public function __construct($baseUrl = "http://api.freebase.com/api/")
    {
        if (\substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $id
     * @return \freebase\Node
     */
    public function fetchByTopicId($id)
    {
        if (\substr($id, 0, 1) === '/') {
            $id = \substr($id, 1); //strip first / if needed as already insured in constructor
        }
        $url = $this->baseUrl . self::PATH_TOPIC .  $id;
        $json = $this->doRequest($url);
        return DomFactory::createDomFromJson($json);
    }

    /**
     * @param Query $query
     * @return \freebase\Node
     */
    public function fetchByQuery(Query $query)
    {
        $url = $this->baseUrl . self::PATH_MQLREAD;
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