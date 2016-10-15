<?php
namespace AppBundle\Features\Context;


use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\ParameterBag;
use Rezzza\RestApiBehatExtension\Rest\RestApiBrowser;
use Rezzza\RestApiBehatExtension\RestApiContext;
use Rezzza\RestApiBehatExtension\Json\JsonInspector;


class RestContext extends RestApiContext
{
    /**
     * @var JsonInspector
     */
    protected $jsonInspector;

    /**
     * @var ParameterBag
     */
    protected static $params;

    public function __construct(RestApiBrowser $restApiBrowser, JsonInspector $jsonInspector)
    {
        parent::__construct($restApiBrowser);
        $this->jsonInspector = $jsonInspector;
    }

    /**
     * @BeforeFeature
     */
    public static function useParameterBag()
    {
        self::$params = new ParameterBag();
    }

    /**
     * Save value of the field in parameters array
     *
     * @Then save the JSON node :node in the :parameter parameter
     */
    public function saveTheJsonNodeInTheParameter($node, $parameter)
    {
        $value = $this->jsonInspector->readJsonNodeValue($node);
        self::$params->set($parameter, $value);
    }

    /**
     * @When count of the JSON node :node should be equal :count
     */
    public function countOfTheJsonNodeShouldBeEqual($node, $count)
    {
        $value = $this->jsonInspector->readJsonNodeValue($node);
        \PHPUnit_Framework_Assert::assertCount(intval($count), $value);
    }

    /**
     * @Then the response should be successful
     */
    public function theResponseShouldBeSuccessful()
    {
        $this->theResponseCodeShouldBe(200);
        $status = $this->jsonInspector->readJsonNodeValue('status');
        \PHPUnit_Framework_Assert::assertEquals(0, $status);
        return $this->jsonInspector->readJsonNodeValue('data');
    }

    /**
     * Save value of the field in parameters array
     *
     * @Then save auth token
     */
    public function saveAuthToken()
    {
        $this->saveTheJsonNodeInTheParameter('token', 'auth_token');
    }

    /**
     * Use auth token
     *
     * @Given use auth token
     */
    public function useAuthToken()
    {
        $token = self::$params->get('auth_token');
        if (is_null($token)) {
            throw new \Exception('No "auth_token"');
        }
        $this->iAddHeaderEqualTo('Authorization', sprintf('Bearer %s', $token));
    }

    /**
     * @Given /^I am anonymous user$/
     */
    public function iAmAnonymousUser()
    {
        self::$params->set('auth_token', null);
    }

    /**
     * I am
     *
     * @Given /^I am an? "?(?P<login>\w*)"? with password "(?P<password>[^\"]*)"/i
     */
    public function iAm($login, $password)
    {
        $this->iSetHeaderEqualTo('Content-Type', 'application/x-www-form-urlencoded');
        $query = http_build_query(array(
            '_username' => $login,
            '_password' => $password,
        ));
        $this->iSendARequestWithBody('POST', 'api/login_check', new PyStringNode(array($query), 1));
        $this->saveAuthToken();
        $this->useAuthToken();
    }

    /**
     * get limited entities list
     *
     * @When /^(?:I )?get (?P<id>\d*) (?P<entitySingleForm>\w*)$/
     */
    public function getEntityWithId($entitySingleForm, $id)
    {
        $this->iSendARequest('GET', sprintf('api/%ss/%s', $entitySingleForm, $id));
    }

    /**
     * get limited entities list
     *
     * @When /^(?:I )?get (?P<entityPluralForm>\w*) from page (?P<page>\d*) with limit (?P<limit>\d*)$/
     */
    public function getEntitiesWithLimit($entityPluralForm, $page, $limit)
    {
        $query = http_build_query(array(
            'page' => $page,
            'limit' => $limit
        ));
        $this->iSendARequest('GET', 'api/'.$entityPluralForm.'?'.$query);
    }

    /**
     * get entities list
     *
     * @When /^(?:I )?get (?P<entityPluralForm>\w*)$/
     */
    public function getEntities($entityPluralForm)
    {
        $this->iSendARequest('GET', 'api/'.$entityPluralForm);
    }

    /**
     * search entities
     *
     * @param $entityPluralForm
     * @param PyStringNode $parameters
     *
     * @When /^(?:I )?search (?P<entityPluralForm>\w*) with parameters:$/i
     * @throws \Exception
     */
    public function iSearchEntities($entityPluralForm, PyStringNode $parameters)
    {
        $this->iSetHeaderEqualTo('Content-Type', 'application/json');
        $this->iSendARequestWithBody('POST', sprintf('api/%s/search', $entityPluralForm), $parameters);
    }


    protected function getJson()
    {
        $this->jsonInspector->readJson();
    }
}