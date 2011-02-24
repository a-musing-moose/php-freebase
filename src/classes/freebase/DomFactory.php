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
    public static function createDomFromJson($json)
    {
        $node = null;
        $data = \json_decode($json, true);
        if (null === $data) {
            throw new \freebase\exception\InvalidJson();
        }
        if (isset($data['code']) && $data['code'] == Constants::API_RESPONSE_CODE_OK ) {
            $node = self::createNode($data['result'], 'root');
        } else {
            $messages = \implode(". ", $data['messages']);
            throw new \freebase\exception\ApiError($messages);
        }
        return $node;
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