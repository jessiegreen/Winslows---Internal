<?php
namespace Dataservice;

class State
{
    /**
     * @var \Dataservice\State\Data 
     */
    protected static $_Data;
    
    public function __construct()
    {
	$this->_Data = new \Dataservice\State\Data();
    }
    
    public function getStatesArray()
    {
	return $this->_Data->getStatesArray();
    }
}