<?php
/**
 * @package
 * @copyright 2011 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;

require_once \dirname(__FILE__) . '/../../../src/freebase/Exception.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/exception/InvalidQuery.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/Query.php';

/**
 * Description of TestQuery
 *
 * @package
 */
class TestQuery extends \PHPUnit_Framework_TestCase
{

    public function testThatNewQueryHasNoCriteria()
    {
        $query = new Query();
        $this->assertEmpty($query->getCriteria());
    }

    public function testThatNewFieldsAreAddCorrectly()
    {
        $query = new Query();
        $query->addField('field', 'value');
        $expected = array('field' => 'value');
        $this->assertSame($expected, $query->getCriteria());

        $query->addField('field', array('a', 'b'));
        $expected = array('field' => array('a', 'b'));
        $this->assertSame($expected, $query->getCriteria());
    }

    public function testThatExceptionIsThrownWhenGeneratingAnEmptyQuery()
    {
        $query = new Query();
        $this->setExpectedException('\\freebase\\exception\\InvalidQuery');
        $query->__toJson();
    }

    public function testThatJsonQueryIsCorrectlyGenerated()
    {
        $query = new Query();
        $query->addField('field', 'value');
        $expected = '{"query":{"field":"value"}}';
        $this->assertSame($expected, $query->__toJson());
    }

}