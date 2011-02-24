<?php
/**
 * @package
 * @copyright 2010 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * Description of Factory
 *
 * @package
 */
class Factory
{

    /**
     * @param string $json
     * @return \freebase\Node
     */
    public static function loadFromJson($json)
    {
        $node = null;
        $data = \json_decode($json, true);
        if (null === $data) {
            throw new \freebase\exception\InvalidJson();
        }
        if (isset($data['code']) && $data['code'] == Enum::API_RESPONSE_CODE_OK ) {
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
                $node->setProperty($key, $value);
            } else {
                $node->addNode(self::createNode($value, $key));
            }
        }
        return $node;
    }

}