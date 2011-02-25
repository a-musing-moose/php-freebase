<?php
/**
 * @package
 * @copyright 2011 Tangent Labs
 * @version SVN: $Id$
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 */
namespace freebase;

require_once \dirname(__FILE__) . '/../../../src/freebase/Exception.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/exception/InvalidJson.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/exception/InvalidPath.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/Constants.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/Node.php';
require_once \dirname(__FILE__) . '/../../../src/freebase/DomFactory.php';

/**
 * Description of TestQuery
 *
 * @package
 */
class TestDomFactory extends \PHPUnit_Framework_TestCase
{

    public function testValidJsonIsParsedIntoNodes()
    {
        $factory = new DomFactory();
        $json = \file_get_contents(\dirname(__FILE__) . '/../../fixtures/topic.json');
        $root = $factory->jsonToDom($json);
        $this->assertInstanceOf('freebase\\Node', $root);
    }

    public function testValidJsonIsParsedIntoCorrectDom()
    {
        $factory = new DomFactory();
        $json = \file_get_contents(\dirname(__FILE__) . '/../../fixtures/topic.json');
        $root = $factory->jsonToDom($json);
        $this->assertSame('Along came a spider', $root->text);
        $this->assertSame('properties', $root->getChildByName('properties')->getName());
        $this->assertSame('Along Came a Spider', $root->getChildByPath('properties./book/book_edition/book.values.0')->text);
    }

    public function testStaticMethodWorks()
    {
        $factory = new DomFactory();
        $json = \file_get_contents(\dirname(__FILE__) . '/../../fixtures/topic.json');
        $root = DomFactory::createDomFromJson($json);
        $this->assertSame('Along came a spider', $root->text);
        $this->assertSame('properties', $root->getChildByName('properties')->getName());
        $this->assertSame('Along Came a Spider', $root->getChildByPath('properties./book/book_edition/book.values.0')->text);
    }

    public function testInvalidJsonThrowsAnException()
    {
        $json = 'a load of crap';
        $factory = new DomFactory();
        $this->setExpectedException('freebase\\exception\\InvalidJson');
        $factory->jsonToDom($json);
    }

   


}