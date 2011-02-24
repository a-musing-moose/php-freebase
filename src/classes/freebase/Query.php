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
        $query = array(
            'q1'=>array(
                'query' => $this->criteria
                )
            );

        return \json_encode($query);
    }

}