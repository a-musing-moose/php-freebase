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

    const PATH_TOPIC = 'experimental/topic/standard/?id=';

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
    public function fetchByTopicId($id, array $domains = array())
    {
        $url = $this->baseUrl . self::PATH_TOPIC .  $id;
        if (!empty($domains)) {
            $url .= '?' . \implode(',', $domains);
        }
        $json = $this->doRequest($url);
        return DomFactory::createDomFromJson($json, $id);
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
        $options = array(
            \CURLOPT_URL => $url,
            \CURLOPT_HEADER => false,
            \CURLOPT_RETURNTRANSFER => true
        );
        if (null !== $jsonData) {
            $options[\CURLOPT_POST] = true;
            $options[\CURLOPT_POSTFIELDS] = array('query' => $jsonData);
        }

        \curl_setopt_array($ch, $options);
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }

}