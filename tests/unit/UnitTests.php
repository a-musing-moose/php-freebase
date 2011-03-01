<?php
require_once dirname(__FILE__).'/freebase/TestQuery.php';
require_once dirname(__FILE__).'/freebase/TestNode.php';
require_once dirname(__FILE__).'/freebase/TestEmptyNode.php';
require_once dirname(__FILE__).'/freebase/TestDomFactory.php';

class UnitTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
        $suite->addTestSuite('freebase\\TestDomFactory');
        $suite->addTestSuite('freebase\\TestNode');
        $suite->addTestSuite('freebase\\TestEmptyNode');
        $suite->addTestSuite('freebase\\TestQuery');
        return $suite;
    }
}
