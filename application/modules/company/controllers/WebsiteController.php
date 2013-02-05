<?php
class Company_WebsiteController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/website.js");
	
	$this->_EntityClass = "Entities\Company\Website";
	
	parent::init();
    }
    
    public function buildResourcesAction()
    {
	/* @var $em \Doctrine\ORM\EntityManager */
	$objResources	= new Dataservice_ACL_Resources;
	
	$this->_requireEntity();
	
	$Default_Role  = $this->_Entity->isGuestAllowed() ? $this->_Entity->getGuestRole() : $this->_Entity->getAdminRole();
	    
	$objResources->buildAllArrays($this->_Entity->getNameIndex());
	$objResources->writeToDB($this->_em, $this->_Entity, $Default_Role);
	
	$this->_FlashMessenger->addSuccessMessage("Resources built");
	$this->_History->goBack();
    }
    
    public function cleanResourcesAction()
    {
	try 
	{
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $objResources	= new Dataservice_ACL_Resources;
	    $this->view->result = $objResources->cleanDB($this->_em);
	} 
	catch (Exception $exc) 
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	}
    }
}

