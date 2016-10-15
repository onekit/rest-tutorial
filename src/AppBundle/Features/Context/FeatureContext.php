<?php

namespace AppBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

class FeatureContext extends MinkContext implements Context
{
    /**
     * @BeforeSuite
     */
    public static function prepare(BeforeSuiteScope $scope)
    {
        // prepare system for test suite
        // before it runs
    }

    /**
     * @AfterScenario @database
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        // clean database after scenarios,
        // tagged with @database
    }


    /**
     * @Given /^I am anonymous user$/
     */
    public function iAmAnonymousUser()
    {
        // remove cookies
        $this->getSession()->reset();

        return true;
    }


}