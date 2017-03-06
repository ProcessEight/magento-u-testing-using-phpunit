# Magento U: Magento Testing Using PHPUnit

This course relates to Magento 1 only

## Setup

The tests are setup so that they exist outside the Magento webroot.

Magento is intended to be installed in a sub-folder, `www`.

To install in a different folder will require updating the paths in both `bootstrap.php` files.

## PhpStorm Setup

### Unit tests

* Create a new test configuration (Run, Edit Configurations...).
* Configure as follows. Replace `/path/to/project/root` with the path to the folder containing the `www` folder (e.g. `/var/www/magento.local/`):
    * Test Runner:
        * Test Scope: Class.
        * Class: Training_Example_DataTest
        * File: `/path/to/project/root/tests/unit/Training/Example/Helper/DataTest.php`
        * Use Alternative Configuration File: `/path/to/project/root/tests/unit/phpunit-unit.xml`
        
### Integration tests

* Create a new test configuration (Run, Edit Configurations...).
* Configure as follows. Replace `/path/to/project/root` with the path to the folder containing the `www` folder (e.g. `/var/www/magento.local/`):
    * Test Runner:
        * Test Scope: Class.
        * Class: Training_Example_DataTest
        * File: `/path/to/project/root/tests/integration/Training/Example/Helper/DataTest.php`
        * Use Alternative Configuration File: `/path/to/project/root/tests/integration/phpunit-integration.xml`
        
## Writing tests

* [Testing in Magento 1](https://gist.github.com/ProjectEight/43f7bc8b0db57b88a85a1d7d74db2a83): A Magento 1-specific overview of writing tests and of best practice
* [Writing more testable code in Magento 1 and 2](https://gist.github.com/ProjectEight/444f1296a9155df857e9ac2707e3d0df): Notes from the Nomad Mage talk on best practices
* [Testing Jargon](https://gist.github.com/ProjectEight/e3cd7ca0f63cc4f7eab13ea3fcbb6f76): Notes from LaraCasts series demystifying common testing terms
* [Testing in Magento 2](https://gist.github.com/ProjectEight/fb7141d120ce05fa837ff4457ca6a747): Has some notes on general best practice when writing tests 
* [Increase Happiness and Reduce Profanity with Browser Testing](https://gist.github.com/ProjectEight/a8920b7d6333c355ee3cc902a19ce7c8): Introduction to functional (browser) testing with Magium
