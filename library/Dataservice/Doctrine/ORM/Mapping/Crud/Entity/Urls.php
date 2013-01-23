<?php
namespace Dataservice\Doctrine\ORM\Mapping\Crud\Entity;

/** 
 * @Annotation 
 * @Target("Class")
 */
final class Urls implements \Doctrine\ORM\Mapping\Annotation
{
    /** @var string */
    public $edit;
    
    /** @var string */
    public $delete;
    
    /** @var string */
    public $create;
}