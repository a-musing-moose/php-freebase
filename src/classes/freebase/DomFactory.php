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
        $node = null;
        $data = \json_decode($json, true);
        if (null === $data) {
            throw new \freebase\exception\InvalidJson($json);
        }
        if (self::getResponseCode($data, $id) == Constants::API_RESPONSE_CODE_OK ) {
            if (null === $id) {
                $node = self::createNode(self::getResultNode($data), 'root');
            } else {
                $node = self::createNode(self::getResultNode($data, $id), $id);
            }
            
        } else {
            throw new \freebase\exception\ApiError("");
        }
        return $node;
    }

    /**
     *
     * @param array $data
     * @param string $id
     * @return string
     */
    protected static function getResponseCode(array $data, $id = null)
    {
        $code = null;
        if (null == $id) {
            $code = isset($data['code']) ? $data['code'] : null;
        } else {
            $code = isset($data[$id]['code']) ? $data[$id]['code'] : null;
        }
        return $code;
    }

    protected static function getResultNode(array $data, $id = null)
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
    protected static function createNode(array $data, $name = null)
    {
        $node = new Node($name);
        foreach ($data as $key => $value) {
            if (\is_scalar($value)) {
                $node->setAttributeValue($key, $value);
            } else {
                $node->addChild(self::createNode($value, $key));
            }
        }
        return $node;
    }

}