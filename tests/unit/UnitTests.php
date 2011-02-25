<?php
require_once dirname(__FILE__).'/freebase/TestQuery.php';
require_once dirname(__FILE__).'/freebase/TestNode.php';
require_once dirname(__FILE__).'/freebase/TestDomFactory.php';

class UnitTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Freebase tests');
        $suite->addTestSuite('freebase\\TestQuery');
        $suite->addTestSuite('freebase\\TestNode');
        $suite->addTestSuite('freebase\\TestDomFactory');
        return $suite;
    }
}
