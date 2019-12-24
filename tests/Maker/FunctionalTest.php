<?php


namespace Pfilsx\FormLayer\Tests;

use Pfilsx\FormLayer\Layer\EntityFormLayer;
use Pfilsx\FormLayer\Maker\MakeFormLayer;
use Pfilsx\FormLayer\Tests\app\Entity\Node;
use Symfony\Bundle\MakerBundle\Command\MakerCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\InputStream;

class FunctionalTest extends KernelTestCase
{
    /**
     * @var string
     */
    private $app_path;

    protected function setUp(): void
    {
        $this->app_path = dirname(__DIR__).'/app';
        parent::setUp();
    }

    public function testWiring()
    {
        $class = MakeFormLayer::class;
        $commandName = $class::getCommandName();
        $this->assertEquals('make:form-layer', $commandName);
        $command = $this->application->find($commandName);
        $this->assertInstanceOf(MakerCommand::class, $command);
    }

    /**
     * @dataProvider getCommands
     * @param $name
     * @param $entity
     * @param $result
     */
    public function testMaker($name, $entity, $result)
    {
        $input = new StringInput("make:form-layer $name $entity");
        $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
        $this->application->run($input, $output);
        $filePath = $this->app_path . "/FormLayer/$name.php";
        $this->assertTrue(is_file($filePath));
        $layerClass = "Pfilsx\\FormLayer\\Tests\\app\\FormLayer\\$name";
        $layer = new $layerClass();
        $this->assertInstanceOf(EntityFormLayer::class, $layer);
        $this->assertEquals($result, get_object_vars($layer));
        @unlink($filePath);
    }

    public function getCommands()
    {
        yield [
            'FooBarTestFormLayer',
            null,
            ['form_field' => null]
        ];
        yield [
            'NodeTestFormLayer',
            'Node',
            [
                'id' => null,
                'content' => null,
                'user' => null,
                'parentId' => null,
                'createdAt' => null,
                'mainNode' => null
            ]
        ];
        yield [
            'ModelTestFormLayer',
            'Model',
            [
                'id' => null,
                'content' => null,
                'createdAt' => null
            ]
        ];
    }
}