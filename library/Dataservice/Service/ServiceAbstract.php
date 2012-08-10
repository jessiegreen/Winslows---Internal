<?php
use Doctrine\ORM\EntityManager;

class Dataservice_Service_ServiceAbstract 
{
    /**
     * @var EntityManager $_em 
     */
    protected $_em;

    public function __construct()
    {
        $front			= \Zend_Controller_Front::getInstance();
	$bootstrap		= $front->getParam("bootstrap");
	$this->_em		= $bootstrap->getResource('entityManager');
    }
    
    public static function factory()
    {
	$class = get_called_class();
	return new $class;
    }    
}

?>
