<?php

/**
 * 
 * @author jessie
 *
 */

class Company_LeadAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $Address \Entities\Person\Address */
	$Address	= $this->getEntityFromParamFields("Person\Address", array("id"));
	
	$form = new Forms\Person\Address(array("method" => "post"), $Address);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["person_address"];
		
		if(isset($data["reset_latlong"]) && $data["reset_latlong"] === 1)
		{
		    $Address->setLatitude();
		    $Address->setLongitude();
		}
		
		$Address->populate($data);
		
		if(!$Address->getId())
		{
		    $lead_id = $this->_getParam("lead_id");

		    if($lead_id)
		    {
			$Lead = $this->_em->find("Entities\Company\Lead", $lead_id);

			if($Lead)
			{
			    $Lead->addAddress($Address);
			    $this->_em->persist($Lead);
			}
			else
			{
			    $this->_FlashMessenger->addErrorMessage("Could not get lead to add address to");
			    $this->_History->goBack();
			}
		    }
		}
		else $this->_em->persist($Address);

		$this->_em->flush();

		$message = "Lead Address saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack(1);
	}
	
	$this->view->form	    = $form;
	$this->view->PersonAddress  = $Address;
    }
}

