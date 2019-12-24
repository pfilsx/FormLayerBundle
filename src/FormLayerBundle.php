<?php


namespace Pfilsx\FormLayer;

use Pfilsx\FormLayer\Layer\FormLayerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FormLayerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->registerForAutoconfiguration(FormLayerInterface::class)->addTag('form_layer.type');
    }
}