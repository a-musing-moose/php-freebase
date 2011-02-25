# php-freebase - A PHP library for [www.freebase.com](http://www.freebase.com "Freebase")

## Installation

### Install PHPUnit
    sudo pear channel-discover pear.phpunit.de
    sudo pear install phpunit/PHPUnit

### Install Phing
    sudo pear channel-discover pear.phing.info
    sudo pear install phing/phing


### Building
php-freebase is designed to be packaged as a phar file. To create the package run:
    phing build-all
This will run all tests, create documentation (in the /docs folder) and creates the Freebase.phar file

## Usage

### Basic Usage

Fetch a topic:
    $freebase = new freebase\Freebase();
    $result = $freebase->fetchByTopicId('/en/philip_k_dick');

Perform a basic search:
    $freebase = new freebase\Freebase();
    $query = new freebase\Query();
    $query->addField('id', '/topic/en/philip_k_dick')
          ->addField('/book/author/works_written', array()); //placeholder for results
    $result = $freebase->fetchByQuery($query);

Using the returned results:

    The results returned from Freebase are formated into a DOM (Document Object Model) which exposes a number of methods to allow you to traverse it and extract the data you need

    $result->getChildByName("properties"); //returns the 'properties' Child Node
    $result->getChildByPath("properties./book/author/works_written"); fetches the /book/author/works_written node within the properties node