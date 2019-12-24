<?php


namespace Pfilsx\FormLayer\Tests;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class KernelTestCase extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{

    /**
     * @var Application
     */
    protected $application;

    protected function setUp(): void
    {

        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
        $this->application->run(new ArrayInput(array(
            'doctrine:schema:drop',
            '--force' => true
        )));
        $this->application->run(new ArrayInput(array(
            'doctrine:schema:create'
        )));
    }
}
