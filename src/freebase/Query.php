<?php
/**
 * @package freebase
 * @copyright 2011 Tangent One
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * Object of this class represent a search of freebase
 *
 * @package freebase
 */
class Query
{

    const EMPTY_QUERY_MESSAGE = "Query is empty";

    protected $criteria = array();

    public function addField($name, $value = null)
    {
        $this->criteria[$name] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return string
     */
    public function __toJson()
    {
        if (empty($this->criteria)) {
            throw new exception\InvalidQuery(self::EMPTY_QUERY_MESSAGE);
        }
        $query = array(
            'query' => $this->criteria
        );

        return \json_encode($query);
    }

}