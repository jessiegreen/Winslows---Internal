<?php
class Company_LeadPhoneNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PhoneNumber \Entities\Company\Lead\PhoneNumber */
	$PhoneNumber	= $this->getEntityFromParamFields("Company\Lead\PhoneNumber", array("id"));
	$lead_id	= $this->_getParam("lead_id");
	
	if($lead_id)
	{
	    $Lead = $this->_em->find("Entities\Company\Lead", $lead_id);
		    
	    if(!$Lead)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get lead Id.");
		$this->_History->goBack();
	    }
	    
	    $PhoneNumber->setLead($Lead);
	}
		
	$form = new Forms\Company\Lead\PhoneNumber($PhoneNumber, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_lead_phone_number"];
		
		$PhoneNumber->populate($data);
		$PhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$PhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$PhoneNumber->setNum2($data["phone_number"]["line"]);
		
		$Lead = $this->_em->find("Entities\Company\Lead", $data["lead_id"]);
		    
		if(!$Lead)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add phone number. No Lead with that Id");
		    $this->_History->goBack();
		}

		$PhoneNumber->setLead($Lead);
		
		$this->_em->persist($PhoneNumber);

		$this->_em->flush();

		$message = "Lead Phone Number saved";
		
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
	$this->view->PhoneNumber  = $PhoneNumber;
    }
}

