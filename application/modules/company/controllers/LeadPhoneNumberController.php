<?php

/**
 * 
 * @author jessie
 *
 */

class Company_LeadPhoneNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PhoneNumber \Entities\Company\Person\PhoneNumber */
	$PhoneNumber	= $this->getEntityFromParamFields("Person\PhoneNumber", array("id"));
	$form		= new Forms\Company\Person\PhoneNumber(array("method" => "post"), $PhoneNumber);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["person_phonenumber"];
		
		$PhoneNumber->populate($data);
		$PhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$PhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$PhoneNumber->setNum2($data["phone_number"]["line"]);
		
		if(!$PhoneNumber->getId()){
		    /* @var $Person \Entities\Company\Person\PersonAbstract */
		    $Lead = $this->_em->find("Entities\Company\Lead", $this->_params["lead_id"]);
		    
		    if(!$Lead)
		    {
			$this->_FlashMessenger->addErrorMessage("Could not get Lead");
			$this->_History->goBack();
		    }

		    $Lead->addPhoneNumber($PhoneNumber);
		    
		    $this->_em->persist($Lead);
		}
		else $this->_em->persist($PhoneNumber);

		$this->_em->flush();

		$message = "Person Phone Number saved";
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
	$this->view->PhoneNumber    = $PhoneNumber;
    }
}

