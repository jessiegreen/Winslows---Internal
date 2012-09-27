<?php

/**
 * 
 * @author jessie
 *
 */

class Company_EmployeePhoneNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PhoneNumber \Entities\Person\PhoneNumber */
	$PhoneNumber	= $this->getEntityFromParamFields("Person\PhoneNumber", array("id"));
	$form		= new Forms\Person\PhoneNumber(array("method" => "post"), $PhoneNumber);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["person_phonenumber"];
		
		$PhoneNumber->populate($data);
		$PhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$PhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$PhoneNumber->setNum2($data["phone_number"]["line"]);
		
		if(!$PhoneNumber->getId()){
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add address. No Person with that Id");

		    $Person->addPhoneNumber($PhoneNumber);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($PhoneNumber);

		$this->_em->flush();

		$message = "Person Phone Number saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form		= $form;
	$this->view->PhoneNumber  = $PhoneNumber;
    }
}

