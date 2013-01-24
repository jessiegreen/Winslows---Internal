<?php
namespace Dataservice\Doctrine\ORM\Mapping\Crud\Entity;

/** 
 * @Annotation 
 * @Target("CLASS")
 */
final class Permissions implements \Doctrine\ORM\Mapping\Annotation
{
    /** @var array<string> */
    public $create;
    /** @var array<string> */
    public $view;
    /** @var array<string> */
    public $edit;
    /** @var array<string> */
    public $delete;
}