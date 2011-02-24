<?php
/**
 * @package
 * @copyright 2010 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * Description of Node
 *
 * @package
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
    protected $nodes = array();

    /**
     * @var \freebase\Node
     */
    protected $parent = null;

    /**
     * @var array
     */
    protected $properties = array();

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

    /////////////////////////////
    // PROPERTY ACCESS METHODS //
    /////////////////////////////

    /**
     * @param mixed $value
     * @return \freebase\Node
     */
    public function setProperty($key, $value)
    {
        $this->properties[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getProperty($key)
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
        $value = null;
        if (\substr($key, 0, 1) == '_') {
            $value = $this->getProperty(\substr($key, 1));
        } else {
            $value = $this->getNodeByName($key);
        }
        return $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function  __set($key, $value)
    {
        if (\substr($key, 0, 1) == '_') {
            $this->setProperty(\substr($key, 1), $value);
        }
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function  __isset($key)
    {
        return isset($this->properties[$key]);
    }

    /////////////////////////
    // NODE ACCESS METHODS //
    /////////////////////////
    
    /**
     * @param \freebase\Node $node
     * @return \freebase\Node
     */
    public function addNode(\freebase\Node $node)
    {
        $node->setParent($this);
        $this->nodes[$node->getName()] = $node;
        return $this;
    }

    /**
     * @return array
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param string $name
     * @return \freebase\Node
     */
    public function getNodeByName($name)
    {
        $node = null;
        if (isset($this->nodes[$name])) {
            $node = $this->nodes[$name];
        }
        return $node;
    }

    public function getNodeByPath($path)
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
        return new \ArrayIterator($this->nodes);
    }

}