<?php


namespace Pfilsx\FormLayer\Tests\app\FormLayer;


use DateTime;
use Pfilsx\FormLayer\Layer\EntityFormLayer;
use Pfilsx\FormLayer\Tests\app\Entity\Model;

class ModelFormLayer extends EntityFormLayer
{
    public $content;
    public $createdAt;

    public static function getEntityClass(): string
    {
        return Model::class;
    }

    protected function loadCreatedAt(?DateTime $val)
    {
        $this->createdAt = $val !== null ? $val->format('d.m.Y') : $val;
    }

    protected function saveCreatedAt()
    {
        return new DateTime($this->createdAt);
    }
}