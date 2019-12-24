<?php


namespace Pfilsx\FormLayer\Renderer;


use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;

class FormLayerRenderer
{
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function render(ClassNameDetails $formClassDetails, array $formFields, ClassNameDetails $boundClassDetails = null)
    {
        $this->generator->generateClass(
            $formClassDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/FormLayer.tpl.php',
            [
                'bounded_full_class_name' => $boundClassDetails ? $boundClassDetails->getFullName() : null,
                'bounded_class_name' => $boundClassDetails ? $boundClassDetails->getShortName() : null,
                'form_fields' => $formFields
            ]
        );
    }
}
