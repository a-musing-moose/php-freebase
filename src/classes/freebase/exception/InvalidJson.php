<?php
/**
 * @package freebase
 * @subpackage exception
 * @copyright 2011 Tangent One
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase\exception;
/**
 * Description of InvalidJson
 *
 * @package freebase
 * @subpackage exception
 */
class InvalidJson extends \freebase\Exception
{

    const MESSAGE = "JSON response could not be parsed";

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}