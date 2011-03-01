<?php
/**
 * @package
 * @copyright 2011 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;

require_once \dirname(__FILE__) . '/../../../src/freebase/Exception.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/Node.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/EmptyNode.php';

/**
 * Description of TestQuery
 *
 * @package
 */
class TestEmptyNode extends \PHPUnit_Framework_TestCase
{

    public function testNewNodeHasNoChildren()
    {
        $node = new Node();
        $this->assertSame(array(), $node->getChildren());
    }

    public function testAttributesAreEmpty()
    {
        $node = new EmptyNode();
        $this->assertSame(array(), $node->getAttributes());
        $node->setAttributeValue("key", "value");
        $this->assertSame(array(), $node->getAttributes());
    }

    public function testRetrievingPropertyAlwaysReturnsNull()
    {
        $node = new EmptyNode();
        $this->assertSame(null, $node->bob);
        $node->bob = 'something';
        $this->assertSame(null, $node->bob);
        $this->assertSame(null, $node->getAttributeValue('bob'));
    }

    public function testRetrievingChildByNameReturnsAnEmptyNode()
    {
        $node = new EmptyNode();
        $this->assertTrue($node->getChildByName('aName') instanceof \freebase\EmptyNode);
    }

    public function testRetrievingChildByPath()
    {
        $node = new EmptyNode();
        $this->assertTrue($node->getChildByPath("one.zombies.eat.brains") instanceof \freebase\EmptyNode);
    }

    public function testThatAnEmptyNodeHasNoChildren()
    {
        $node = new EmptyNode();
        $this->assertSame(array(), $node->getChildren());
        $node->addChild(new EmptyNode());
        $this->assertSame(array(), $node->getChildren());
    }
}