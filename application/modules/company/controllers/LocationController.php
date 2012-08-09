<?php

/**
 * 
 * @author jessie
 *
 */

class Company_LocationController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/location.js");
	parent::init();
    }
    
    public function viewAction()
    {
	$Location = $this->getEntityFromParamFields("Company\Location", array("id"));
	
	if(!$Location->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Location");
	    $this->_History->goBack();
	}
	
	$this->view->Location	= $Location;
    }
    
    public function editAction()
    {
	$Location   = $this->getEntityFromParamFields("Company\Location", array("id"));
	$company_id = $this->_request->getParam("company_id", null);
	
	if($company_id)
	{
	    $Company = $this->_em->find("Entities\Company", $company_id);
	    if($Company)$Location->setCompany($Company);
	}
	
	$form = new Forms\Company\Location(array("method" => "post"), $Location);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$location_data	= $this->_params["company_location"];
		$Company	= $this->_em->find("Entities\Company", $location_data["company_id"]);
		
		if($Company)$Location->setCompany($Company);
		
		$Location->populate($location_data);
		$this->_em->persist($Location);
		$this->_em->flush();

		$message = "Location '".htmlspecialchars($Location->getName())."' saved";
		
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
	$this->view->Location	= $Location;
    }
}

