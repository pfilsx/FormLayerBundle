<?php


namespace Pfilsx\FormLayer\Tests\Layer;


use DateTime;
use Pfilsx\FormLayer\Exception\InvalidArgumentException;
use Pfilsx\FormLayer\Tests\app\Entity\Model;
use Pfilsx\FormLayer\Tests\app\Entity\Node;
use Pfilsx\FormLayer\Tests\app\FormLayer\ModelFormLayer;
use Pfilsx\FormLayer\Tests\app\FormLayer\NodeFormLayer;
use PHPUnit\Framework\TestCase;

class EntityFormLayerTest extends TestCase
{
    /**
     * @dataProvider getLayers
     * @param string $formLayerClass
     * @param string $entityClass
     * @param bool $useMethod
     */
    public function testEmptyCreate($formLayerClass, $entityClass, $useMethod)
    {
        /**
         * @var NodeFormLayer|ModelFormLayer $layer
         */
        $layer = new $formLayerClass();
        $this->assertNull($layer->getId());
        $this->assertNull($layer->createdAt);
        $this->assertNull($layer->content);

        $layer->createdAt = '01.01.1970';
        $node = $layer->create();
        $this->assertInstanceOf($entityClass, $node);
        $this->assertEquals(new DateTime('01.01.1970'), $useMethod ? $node->getCreatedAt() : $node->createdAt);
    }

    /**
     * @dataProvider getLayers
     * @param string $formLayerClass
     */
    public function testWrongLoad($formLayerClass)
    {
        $node = new class {
        };
        /**
         * @var NodeFormLayer|ModelFormLayer $layer
         */
        $layer = new $formLayerClass();
        $this->expectException(InvalidArgumentException::class);
        $layer->load($node);
    }

    /**
     * @dataProvider getLayers
     * @param string $formLayerClass
     * @param string $entityClass
     */
    public function testLoad($formLayerClass, $entityClass, $useMethod)
    {
        /**
         * @var Node|Model $node
         */
        $node = new $entityClass();
        if ($useMethod) {
            $node->setCreatedAt(new DateTime('01.01.1970'))
                ->setId(1)->setContent('Test content');
        } else {
            $node->createdAt = new DateTime('01.01.1970');
            $node->id = 1;
            $node->content = 'Test content';
        }
        /**
         * @var NodeFormLayer|ModelFormLayer $layer
         */
        $layer = new $formLayerClass();
        $layer->load($node);
        $this->assertEquals(1, $layer->getId());
        $this->assertEquals('01.01.1970', $layer->createdAt);
        $this->assertEquals('Test content', $layer->content);

        $layer->createdAt = '02.01.1970';
        $layer->update();
        $this->assertEquals(new DateTime('02.01.1970'), $useMethod ? $node->getCreatedAt() : $node->createdAt);
    }

    /**
     * @dataProvider getLayers
     * @param string $formLayerClass
     * @param string $entityClass
     */
    public function testForceCreate($formLayerClass, $entityClass)
    {
        /**
         * @var Node|Model $node
         */
        $node = new $entityClass();
        /**
         * @var NodeFormLayer|ModelFormLayer $layer
         */
        $layer = new $formLayerClass();
        $layer->load($node);
        $this->assertSame($node, $layer->create());
        $this->assertNotSame($node, $layer->create(true));
    }

    public function getLayers()
    {
        yield [
            NodeFormLayer::class,
            Node::class,
            true
        ];
        yield [
            ModelFormLayer::class,
            Model::class,
            false
        ];
    }
}
