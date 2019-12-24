<?php


namespace Pfilsx\FormLayer\Layer;

use Pfilsx\FormLayer\Exception\InvalidArgumentException;

abstract class EntityFormLayer implements FormLayerInterface
{
    protected $entity;

    /**
     * Associated entity FQN
     * @return string
     */
    abstract public static function getEntityClass(): string;

    /**
     * Returns entity identifier
     * @return int|null
     */
    public function getId(): ?int
    {
        if ($this->entity !== null) {
            if (method_exists($this->entity, 'getId')) {
                return $this->entity->getId();
            }
            if (property_exists($this->entity, 'id')) {
                return $this->entity->id;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function load($entity)
    {
        if (!is_a($entity, static::getEntityClass())) {
            throw new InvalidArgumentException('Expected instance of ' . static::getEntityClass() . ', got ' . get_class($entity));
        }
        $this->entity = $entity;
        $this->loadLayerFields();
    }

    /**
     * @inheritDoc
     */
    public function create(bool $force = false)
    {
        if ($force || $this->entity === null) {
            $className = static::getEntityClass();
            $this->entity = new $className();
        }
        $this->update();
        return $this->entity;
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        if ($this->entity !== null) {
            $this->loadEntityFields();
        }
    }

    /**
     * Loads data from associated entity
     */
    protected function loadLayerFields()
    {
        foreach (get_object_vars($this) as $prop => $val) {
            $getter = 'get' . $prop;
            $value = $val;
            if (method_exists($this->entity, $getter)) {
                $value = $this->entity->$getter();
            } elseif (property_exists($this->entity, $prop)) {
                $value = $this->entity->$prop;
            }
            $loadMethod = 'load' . $prop;
            if (method_exists($this, $loadMethod)) {
                $this->$loadMethod($value);
            } else {
                $this->$prop = $value;
            }
        }
    }

    /**
     * Saves data into associated entity
     */
    protected function loadEntityFields()
    {
        foreach (get_object_vars($this) as $prop => $value) {
            $saveMethod = 'save' . $prop;
            $value = method_exists($this, $saveMethod) ? $this->$saveMethod() : $this->$prop;
            $setter = 'set' . $prop;
            if (method_exists($this->entity, $setter)) {
                $this->entity->$setter($value);
            } elseif (property_exists($this->entity, $prop)) {
                $this->entity->$prop = $value;
            }
        }
    }
}
