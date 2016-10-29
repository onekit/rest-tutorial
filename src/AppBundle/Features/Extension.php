<?php

namespace AppBundle\Features;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Extension implements ExtensionInterface
{
    public function load(ContainerBuilder $container, array $config)
    {
        $parser = new \Symfony\Component\Yaml\Parser();
        $data = $parser->parse(file_get_contents('app/config/parameters.yml'));
        $container->setParameter('rezzza.json_api.rest.base_url', sprintf('http://%s/app_dev.php/', $data['parameters']['http_host']));
    }

    public function configure(ArrayNodeDefinition $builder)
    {
    }

    public function getConfigKey()
    {
        return 'rest_api';
    }

    public function process(ContainerBuilder $container)
    {
    }

    public function initialize(ExtensionManager $extensionManager)
    {
    }
}

