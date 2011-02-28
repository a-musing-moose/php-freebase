<?php
require_once dirname(__FILE__).'/freebase/TestQuery.php';
require_once dirname(__FILE__).'/freebase/TestNode.php';
require_once dirname(__FILE__).'/freebase/TestDomFactory.php';
require_once dirname(__FILE__).'/freebase/TestBlank.php';

class UnitTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
        $suite->addTestSuite('freebase\\TestDomFactory');
        $suite->addTestSuite('freebase\\TestNode');
        $suite->addTestSuite('freebase\\TestQuery');
        $suite->addTestSuite('freebase\\TestBlank');  //when in phar file the last unit test does not print it's results so i added a blank one
        return $suite;
    }
}
