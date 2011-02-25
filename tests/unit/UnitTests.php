<?php
require_once dirname(__FILE__).'/freebase/TestQuery.php';
class UnitTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Freebase tests');
        $suite->addTestSuite('freebase\\TestQuery');
        return $suite;
    }
}
