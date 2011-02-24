<?php
/**
 * @package freebase
 * @copyright 2010 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase\exception;
/**
 * @package freebase
 */
class InvalidPath extends \freebase\Exception
{

    const TEMPLATE = "The path %s could not be found in this document";

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct(\sprint_f(self::TEMPLATE, $path));
    }

}