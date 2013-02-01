<?php
class Company_LeadController extends Dataservice_Controller_Crud_Action
{
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Lead";
	
	parent::init();
    }
    
    public function viewSalesAction()
    {
	/* @var $Lead \Entities\Company\Lead */
	$Lead	    = $this->getEntityFromParamFields("Company\Lead", array("id"));
	$Employee   = $this->_Website->getCurrentUserAccount(Zend_Auth::getInstance())->getPerson();
	
	if(!$Lead->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Lead");
	    $this->_History->goBack();
	}
	
	if(!$Employee->canSeeLead($Lead))
	{
	    $this->_FlashMessenger->addErrorMessage("You are not allowed to view Lead");
	    $this->_History->goBack();
	}
	
	$this->view->Lead = $Lead;
	$this->view->back = $this->_History->getPreviousUrl();
    }
}

