<?php
/**
 * @package freebase
 * @copyright 2011 Tangent One
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * Description of Node
 *
 * @package freebase
 */
class Node implements \IteratorAggregate
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $children = array();

    /**
     * @var \freebase\Node
     */
    protected $parent = null;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @param string $name
     */
    public function  __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \freebase\Node
     */
    public function getParent()
    {
       return $this->parent;
    }


    /**
     * @param \freebase\Node $parent
     * @return \freebase\Node
     */
    public function setParent(\freebase\Node $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    //////////////////////////////
    // ATTRIBUTE ACCESS METHODS //
    //////////////////////////////

    /**
     * @param mixed $value
     * @return \freebase\Node
     */
    public function setAttributeValue($key, $value)
    {
        $this->properties[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        $value = null;
        if (\array_key_exists($key, $this->properties)) {
            $value = $this->properties[$key];
        }
        return $value;
    }

    /**
     * @param string $key
     * @return mixed 
     */
    public function  __get($key) {
        return $this->getAttributeValue($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function  __set($key, $value)
    {
        $this->setAttributeValue($key, $value);
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function  __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /////////////////////////
    // NODE ACCESS METHODS //
    /////////////////////////
    
    /**
     * @param \freebase\Node $node
     * @return \freebase\Node
     */
    public function addChild(\freebase\Node $node)
    {
        $node->setParent($this);
        $this->children[$node->getName()] = $node;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->nodes;
    }

    /**
     * @param string $name
     * @return \freebase\Node
     */
    public function getChildByName($name)
    {
        $node = null;
        if (isset($this->nodes[$name])) {
            $node = $this->nodes[$name];
        }
        return $node;
    }

    public function getChildByPath($path)
    {
        $nodeList = \explode(".", $path);
        $node = $this;
        foreach ($nodeList as $name) {
            if (null === $node) {
                break;
            }
            $node = $node->getNodeByName($name);
        }
        if (null === $node) {
            throw new exception\InvalidPath($path);
        }
        return $node;
    }

    /////////////////////////////////
    // IteratorAggregate INTERFACE //
    /////////////////////////////////

    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

}