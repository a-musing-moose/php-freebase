<?php
/**
 * @package freebase
 * @copyright 2011 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * @package freebase
 */
class EmptyNode extends Node
{


    /**
     * Returns all attributes as an array keyed by the attribute name
     *
     * @return array
     */
    public function getAttributes()
    {
        return array();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        return null;
    }



    /**
     * @return array
     */
    public function getChildren()
    {
        return array($this);
    }

    /**
     * @param string $name
     * @return \freebase\Node
     */
    public function getChildByName($name)
    {
        return $this;
    }

    /**
     * @param string $path Names should be separated by '.' characters
     * @return \freebase\Node
     */
    public function getChildByPath($path)
    {
        return $this;
    }
}