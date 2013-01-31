<?php
namespace Dataservice\Doctrine\ORM\Mapping\Crud\Entity;

/** 
 * @Annotation 
 * @Target("CLASS")
 */
final class Url implements \Doctrine\ORM\Mapping\Annotation
{
    /**
     * @var string
     */
    public $value;
}