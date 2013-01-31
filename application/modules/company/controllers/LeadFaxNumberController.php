<?php
class Company_LeadFaxNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $FaxNumber \Entities\Company\Lead\FaxNumber */
	$FaxNumber	= $this->getEntityFromParamFields("Company\Lead\FaxNumber", array("id"));
	$lead_id	= $this->_getParam("lead_id");
	
	if($lead_id)
	{
	    $Lead = $this->_em->find("Entities\Company\Lead", $lead_id);
		    
	    if(!$Lead)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get lead Id.");
		$this->_History->goBack();
	    }
	    
	    $FaxNumber->setLead($Lead);
	}
		
	$form = new Forms\Company\Lead\FaxNumber($FaxNumber, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_lead_fax_number"];
		
		$FaxNumber->populate($data);
		$FaxNumber->setAreaCode($data["fax_number"]["area"]);
		$FaxNumber->setNum1($data["fax_number"]["prefix"]);
		$FaxNumber->setNum2($data["fax_number"]["line"]);
		
		$Lead = $this->_em->find("Entities\Company\Lead", $data["lead_id"]);
		    
		if(!$Lead)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add fax number. No Lead with that Id");
		    $this->_History->goBack();
		}

		$FaxNumber->setLead($Lead);
		
		$this->_em->persist($FaxNumber);

		$this->_em->flush();

		$message = "Lead Fax Number saved";
		
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
	$this->view->FaxNumber  = $FaxNumber;
    }
}

