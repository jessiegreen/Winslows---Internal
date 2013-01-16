<?php

class Company_LeadController extends Dataservice_Controller_Action
{
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/lead.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	$Lead = $this->getEntityFromParamFields("Company\Lead", array("id"));

	$form = new \Forms\Company\Lead(array("method" => "post"), $Lead);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$lead_data	= $this->_params["company_lead"];
		$Employee	= $this->_em->find("Entities\Company\Employee", $lead_data["employee"]);
		
		$Lead->setEmployee($Employee);
		$Lead->populate($lead_data);
		
		$this->_em->persist($Lead);
		$this->_em->flush();

		$message = "Lead '".htmlspecialchars($Lead->getFullName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();		
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
    
    public function viewAction()
    {	
	$Lead = $this->getEntityFromParamFields("Company\Lead", array("id"));
	
	if(!$Lead->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Lead");
	    $this->_History->goBack();
	}
	
	$this->view->Lead = $Lead;
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

