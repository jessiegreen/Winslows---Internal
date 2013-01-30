<?php
namespace Dataservice\Doctrine\ORM\Mapping\Crud\Relationship;

/** 
 * @Annotation 
 * @Target("PROPERTY")
 */
final class Permissions implements \Doctrine\ORM\Mapping\Annotation
{
    /** @var array<string> */
    public $add;
    /** @var array<string> */
    public $remove;
}