<?php
/**
 * @package freebase
 * @copyright 2010 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;
/**
 * @package freebase
 */
class Enum
{
    const API_RESPONSE_CODE_OK = '/api/status/ok';
    const API_RESPONSE_CODE_ERROR = '/api/status/error';

    /**
     * Attribute types that need special handling
     */
    const ATTRIB_TYPE = 'type';
    const ATTRIB_EXPECTED_TYPE = 'expected_type';
}