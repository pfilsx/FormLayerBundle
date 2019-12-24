<?= "<?php\n" ?>

namespace <?= $namespace ?>;

<?php if (class_exists('Symfony\Component\Validator\Constraint')) : ?>
use Symfony\Component\Validator\Constraints as Assert;
<?php endif ?>
use Pfilsx\FormLayer\Layer\EntityFormLayer;

<?php if ($bounded_full_class_name): ?>
use <?= $bounded_full_class_name ?>;

/**
* @method <?= $bounded_class_name ?> create(bool $force = false)
* @method void load(<?= $bounded_class_name ?> $entity)
*/
<?php endif ?>
class <?= $class_name ?> extends EntityFormLayer
{
<?php foreach ($form_fields as $form_field): ?>
    public $<?= $form_field ?>;

<?php endforeach; ?>
    public static function getEntityClass(): string
    {
        return <?= !empty($bounded_class_name) ? "$bounded_class_name::class" : "''" ?>;
    }
}