<?php

/**
 * 
 * @author jessie
 *
 */

class Company_LeadEmailAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $EmailAddress \Entities\Company\Lead\EmailAddress */
	$EmailAddress	= $this->getEntityFromParamFields("Company\Lead\EmailAddress", array("id"));
	$lead_id	= $this->_getParam("lead_id");
	
	if($lead_id)
	{
	    $Lead = $this->_em->find("Entities\Company\Lead", $lead_id);
		    
	    if(!$Lead)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get lead Id.");
		$this->_History->goBack();
	    }
	    
	    $EmailAddress->setLead($Lead);
	}
		
	$form = new Forms\Company\Lead\EmailAddress($EmailAddress, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->_params["company_lead_email_address"];
		
		$EmailAddress->populate($data);
		
		$Lead = $this->_em->find("Entities\Company\Lead", $data["lead_id"]);
		    
		if(!$Lead)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add email address. No Lead with that Id");
		    $this->_History->goBack();
		}

		$EmailAddress->setLead($Lead);
		
		$this->_em->persist($EmailAddress);

		$this->_em->flush();

		$message = "Lead Email Address saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	  = $form;
	$this->view->EmailAddress  = $EmailAddress;
    }
}

