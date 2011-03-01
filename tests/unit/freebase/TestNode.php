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
class TestNode extends \PHPUnit_Framework_TestCase
{

    public function testNewNodeHasNoChildren()
    {
        $node = new Node();
        $this->assertSame(array(), $node->getChildren());
    }

    public function testCanAddChildren()
    {
        $node = new Node();
        $child = new Node();
        $node->addChild($child);
        $allChildren = $node->getChildren();
        $this->assertSame(1, count($allChildren));
        $this->assertSame($child, $allChildren[0]);
    }

    public function testCanAddAttributes()
    {
        $node = new Node();
        $node->setAttributeValue('key', 'value');
        $this->assertSame(1, count($node->getAttributes()));
        $this->assertSame('value', $node->getAttributeValue('key'));

        $node->setAttributeValue('key2', 'value2');
        $this->assertSame('value2', $node->getAttributeValue('key2'));
    }

    public function testMagicAttributes()
    {
        $node = new Node();
        $this->assertFalse(isset($node->dev));
        $node->dev = 'francis';
        $this->assertTrue(isset($node->dev));
        $this->assertSame('francis', $node->dev);
    }

    public function testICanForEachTheChildren()
    {
        $node = new Node();
        $node->addChild(new Node('one'));
        $node->addChild(new Node('two'));
        $node->addChild(new Node('three'));
        $this->assertSame(3, count($node->getChildren()));
        $count = 0;
        foreach ($node as $child) {
            ++$count;
        }
        $this->assertSame(3, $count);
    }

    public function testRetrievingChildByName()
    {
        $node = new Node();
        $c1 = new Node('one');
        $c2 = new Node('two');
        $c3 = new Node('three');
        $node->addChild($c1);
        $node->addChild($c2);
        $node->addChild($c3);
        $this->assertSame($c2, $node->getChildByName('two'));
    }

    public function testRetrievingChildByPath()
    {
        $node = new Node();
        $c1 = new Node('one');
        $c2 = new Node('two');
        $c3 = new Node('three');

        $c2->addChild($c3);
        $c1->addChild($c2);
        $node->addChild($c1);

        $this->assertSame($c2, $node->getChildByPath("one.two"));
        $this->assertTrue($node->getChildByPath("one.zombies.eat.brains") instanceof \freebase\EmptyNode);
    }

    public function testThatICanGetANodesParent()
    {
        $node = new Node();
        $c1 = new Node('one');
        $c2 = new Node('two');

        $c1->addChild($c2);
        $node->addChild($c1);

        $this->assertSame($c1, $c2->getParent());
    }


}