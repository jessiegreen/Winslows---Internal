<?php
class Company_LeadAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $Address \Entities\Company\Lead\Address */
	$Address	= $this->getEntityFromParamFields("Company\Lead\Address", array("id"));
	$lead_id	= $this->_getParam("lead_id");
	
	if($lead_id)
	{
	    $Lead = $this->_em->find("Entities\Company\Lead", $lead_id);
		    
	    if(!$Lead)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get lead Id.");
		$this->_History->goBack();
	    }
	    
	    $Address->setLead($Lead);
	}
	
	$form		= new \Forms\Company\Lead\Address($Address, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_lead_address"];
		
		$Address->populate($data);
		
		$Lead = $this->_em->find("Entities\Company\Lead", $data["lead_id"]);
		    
		if(!$Lead)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add address. No Lead with that Id");
		    $this->_History->goBack();
		}

		$Address->setLead($Lead);
		
		$this->_em->persist($Address);

		$this->_em->flush();

		$message = "Lead Address saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);

	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    $this->_History->goBack();
	}
	
	$this->view->form	    = $form;
	$this->view->LeadAddress  = $Address;
    }
}

