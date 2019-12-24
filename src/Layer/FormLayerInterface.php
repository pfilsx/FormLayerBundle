<?php


namespace Pfilsx\FormLayer\Layer;


interface FormLayerInterface
{
    /**
     * Loads data from entity and create association
     * @param object|mixed $entity
     */
    public function load($entity);

    /**
     * Creates new entity object or updates associated if exists
     * @param bool $force - forces creation of new entity object even if associated exists
     * @return object|mixed
     */
    public function create(bool $force = false);

    /**
     * Updates associated entity
     * @return void
     */
    public function update();
}
