<?php
namespace Entities\Contact\Party\Participant;

class Entity
{
    protected $class;
    protected $id;
    
    public function setClass($class)
    {
	$this->class = $class;
    }
    
    public function setId($id)
    {
	$this->id = $id;
    }
}

