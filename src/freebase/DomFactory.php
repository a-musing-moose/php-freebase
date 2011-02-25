<?php
/**
 * @package freebase
 * @copyright 2011 Tangent One
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * The response factory class provides method to generate a Node DOM from freebase responses
 *
 * @package freebase
 */
class DomFactory
{

     /**
     * @param string $json
     * @return \freebase\Node
     */
    public static function createDomFromJson($json, $id = null)
    {
        $factory = new self;
        return $factory->jsonToDom($json, $id);
    }

    /**
     * @param string $json
     * @param string $id
     * @return Node
     */
    public function jsonToDom($json, $id = null)
    {
        $root = null;
        $data = \json_decode($json, true);
        if (null === $data) {
            throw new \freebase\exception\InvalidJson($json);
        }
        if ($this->getResponseCode($data, $id) == Constants::API_RESPONSE_CODE_OK ) {
            $root = $this->createNode($this->getResultNode($data, $id), $id);
        } else {
            //@todo error parsing requires a little more work methinks
            throw new \freebase\exception\ApiError("");
        }
        return $root;
    }

    /**
     *
     * @param array $data
     * @param string $id
     * @return string
     */
    protected function getResponseCode(array $data, $id = null)
    {
        $code = null;
        if (null == $id) {
            $code = isset($data['code']) ? $data['code'] : null;
        } else {
            $code = isset($data[$id]['code']) ? $data[$id]['code'] : null;
        }
        return $code;
    }

    /**
     * @param array $data
     * @param string $id
     * @return array
     */
    protected function getResultNode(array $data, $id = null)
    {
        $result = null;
        if (null == $id) {
            $result = $data['result'];
        } else {
            $result = $data[$id]['result'];
        }
        return $result;
    }

    /**
     * @param array $data
     * @param string $name
     * @return \freebase\Node
     */
    protected function createNode(array $data, $name = null)
    {
        $node = new Node($name);
        foreach ($data as $key => $value) {
            if (\is_scalar($value)) {
                $node->setAttributeValue($key, $value);
            } else {
                $node->addChild($this->createNode($value, $key));
            }
        }
        return $node;
    }

}