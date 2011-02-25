<?php
/**
 * @author Jonathan Moss <jonathan.moss@tangentone.com.au>
 * @copyright 2011 Tangent One
 */

Phar::mapPhar();

if (php_sapi_name() == 'cli' && isset ($argv[1])) {
    $runner = new CliRunner();
    $runner->processParameters($argv);
} else {
    //register the autoloader
    spl_autoload_register(array('FreebaseAutoLoader', 'load'));
}

/**
 * Autoloader for the wotsit package
 */
class FreebaseAutoLoader
{

    /**
     * A static array of classes
     *
     * @var array
     */
    private static $classes = array(
                //exceptions
        'freebase\\exception\\ApiError'       => 'phar://Freebase/src/freebase/exception/ApiError.php',
        'freebase\\exception\\InvalidJson'    => 'phar://Freebase/src/freebase/exception/InvalidJson.php',
        'freebase\\exception\\InvalidPath'    => 'phar://Freebase/src/freebase/exception/InvalidPath.php',
        'freebase\\exception\\InvalidQuery'   => 'phar://Freebase/src/freebase/exception/InvalidQuery.php',

        //real stuff
        'freebase\\Constants'                 => 'phar://Freebase/src/freebase/Constants.php',
        'freebase\\DomFactory'                => 'phar://Freebase/src/freebase/DomFactory.php',
        'freebase\\Exception'                 => 'phar://Freebase/src/freebase/Exception.php',
        'freebase\\Freebase'                  => 'phar://Freebase/src/freebase/Freebase.php',
        'freebase\\Node'                      => 'phar://Freebase/src/freebase/Node.php',
        'freebase\\Query'                     => 'phar://Freebase/src/freebase/Query.php',
    );

    /**
     * class loader
     *
     * @param string $className
     * @return boolean
     */
    public static function load($className)
    {
        $isLoaded = false;
        if (isset(self::$classes[$className])) {
            include self::$classes[$className];
            $isLoaded = true;
        }
        return $isLoaded;
    }

}

/**
 * Cli runner
 */
class CliRunner
{

    /**
     * @param array $argv
     * @return void
     */
    public function processParameters(array $argv)
    {
        $filename = $argv[0];
        $switches = array();
        $commands = array();
        foreach (array_slice($argv, 1) as $arg) {
            if (substr($arg, 0, 2) == '--') {
                $switches[] = $arg;
            } else {
                $commands[] = $arg;
            }
        }

        switch (true) {
        case in_array('test', $commands):
            require_once 'PHPUnit/Autoload.php';
            $verbose = in_array('--verbose', $switches);
            $this->printHeader($filename);
            if (in_array('--testdox', $switches)) {
                $listener = new PHPUnit_Util_TestDox_ResultPrinter_Text();
            } else {
                $listener = new PHPUnit_TextUI_ResultPrinter(null, $verbose);
            }
            $this->runTests($listener);
            break;
        case in_array('list', $commands):
            $this->printHeader($filename);
            $this->listContent($filename);
            break;
        case in_array('--help', $switches):
        case in_array('help', $commands):
        default:
            $this->printHeader($filename);
            $this->printHelp();
            break;
        }
    }

    /**
     * @param PHPUnit_Framework_TestListener $listener
     * @return void
     */
    private function runTests(PHPUnit_Framework_TestListener $listener)
    {
        echo "RUNNING TEST SUITE:\n^^^^^^^^^^^^^^^^^^^\n";
        set_include_path(get_include_path() . PATH_SEPARATOR . 'Freebase.phar');
        require_once 'phar://Freebase/tests/unit/UnitTests.php';
        $suite = UnitTests::suite();
        $result = new PHPUnit_Framework_TestResult;
        $result->addListener($listener);
        $suite->run($result);
        echo "\n";
        die((int)$result->wasSuccessful());
    }

    /**
     * @param string $filename
     * @return void
     */
    private function listContent($filename)
    {
        $p = new Phar($filename, 0);
        echo "LISTING METADATA\n^^^^^^^^^^^^^^^^\n";
        foreach ($p->getMetadata() as $key => $value) {
            echo "\t{$key}: {$value}\n";
        }

        echo "\nLISTING CONTENTS\n^^^^^^^^^^^^^^^^\n";
        foreach (new RecursiveIteratorIterator($p) as $file) {
            $path = $file->getPathname();
            $path = substr($path, strpos($path, $filename) + strlen($filename));
            echo "\t{$path}\n";
        }
    }

    /**
     * @param string $filename
     * @return void
     */
    private function printHeader($filename)
    {
        $p = new Phar($filename, 0);

        $meta = $p->getMetadata();
        echo <<<EOD
{$meta['Title']} by {$meta['Author']}

EOD;

    }

    /**
     * @return void
     */
    private function printHelp()
    {
        echo <<<EOD
Usage: php Wotsit.phar [switches] test
       php Wotsit.phar [switches] help
       php Wotsit.phar [switches] list

Actions:
  test              Runs the unit test suite
  help              Show this usage information
  list              Lists the metadata and file content of this library

Switches:
  --verbose         Will output a more verbose test report
  --testdox         Will output a test results in the testdox format


EOD;
    die();
    }

}

__HALT_COMPILER();