<?php
namespace AppBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class AppExtension implements  ExtensionInterface
{
    public function getAlias()
    {
        return 'app';
    }

    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    public function getXsdValidationBasePath()
    {
        // TODO: Implement getXsdValidationBasePath() method.
    }

    public function load(array $config, ContainerBuilder $container)
    {
        //fos_user.model_manager_name
    }
}