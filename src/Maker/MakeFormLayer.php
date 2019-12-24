<?php


namespace Pfilsx\FormLayer\Maker;


use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\Mapping\ClassMetadata;
use Pfilsx\FormLayer\Renderer\FormLayerRenderer;
use ReflectionClass;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Doctrine\DoctrineHelper;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

class MakeFormLayer extends AbstractMaker
{
    private $entityHelper;
    private $formLayerRenderer;

    public function __construct(DoctrineHelper $entityHelper, FormLayerRenderer $formLayerRenderer)
    {
        $this->entityHelper = $entityHelper;
        $this->formLayerRenderer = $formLayerRenderer;
    }

    public static function getCommandName(): string
    {
        return 'make:form-layer';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription('Creates a new form layer class')
            ->addArgument('name', InputArgument::OPTIONAL, sprintf('The name of the form layer class (e.g. <fg=yellow>%sFormLayer</>)', Str::asClassName(Str::getRandomTerm())))
            ->addArgument('bound-class', InputArgument::OPTIONAL, 'The name of Entity or fully qualified model class name that the new form will be bound to (empty for none)');
        $inputConfig->setArgumentAsNonInteractive('bound-class');
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            DoctrineBundle::class,
            'orm'
        );
    }

    /**
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Command $command
     *
     * @codeCoverageIgnore
     */
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        if (null === $input->getArgument('bound-class')) {
            $argument = $command->getDefinition()->getArgument('bound-class');
            $entities = $this->entityHelper->getEntitiesForAutocomplete();
            $question = new Question($argument->getDescription());
            $question->setValidator(function ($answer) use ($entities) {return Validator::existsOrNull($answer, $entities); });
            $question->setAutocompleterValues($entities);
            $question->setMaxAttempts(3);
            $input->setArgument('bound-class', $io->askQuestion($question));
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $formClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'FormLayer\\',
            'FormLayer'
        );

        $formFields = ['form_field'];

        $boundClass = $input->getArgument('bound-class');
        $boundClassDetails = null;
        if (null !== $boundClass) {
            $formFields = [];
            $boundClassDetails = $generator->createClassNameDetails(
                $boundClass,
                'Entity\\'
            );
            $doctrineMetadata = $this->entityHelper->getMetadata($boundClassDetails->getFullName());
            if ($doctrineMetadata instanceof ClassMetadata) {
                foreach ($doctrineMetadata->getFieldNames() as $fieldName){
                    $formFields[] = $fieldName;
                }
                foreach ($doctrineMetadata->associationMappings as $fieldName => $relation) {
                    if ($relation['type'] === ClassMetadata::MANY_TO_ONE) {
                        $formFields[] = $fieldName;
                    }
                }
            } else {
                $reflect = new ReflectionClass($boundClassDetails->getFullName());
                foreach ($reflect->getProperties() as $prop) {
                    $formFields[] = $prop->getName();
                }
            }
        }

        $this->formLayerRenderer->render(
            $formClassNameDetails,
            $formFields,
            $boundClassDetails
        );
        $generator->writeChanges();
        $this->writeSuccessMessage($io);
        $io->text('Next: Add fields to your form layer and start using it.');
    }
}