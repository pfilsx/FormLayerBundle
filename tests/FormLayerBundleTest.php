<?php


namespace Pfilsx\FormLayer\Tests;


use Pfilsx\FormLayer\FormLayerBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormLayerBundleTest extends TestCase
{
    public function testBundle()
    {
        $bundle = new FormLayerBundle();
        $container = new ContainerBuilder();
        $bundle->build($container);
        $this->assertEquals('FormLayerBundle', $bundle->getName());
    }
}