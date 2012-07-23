<?php

/**
 * 
 * @author jessie
 *
 */

class PersonphonenumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PersonPhoneNumber \Entities\PersonPhoneNumber */
	$PersonPhoneNumber  = $this->getEntityFromParamFields("PersonPhoneNumber", array("id"));
	$form		    = new Form_PersonPhoneNumber(array("method" => "post"), $PersonPhoneNumber);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["personphonenumber"];
		
		$PersonPhoneNumber->populate($data);
		$PersonPhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$PersonPhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$PersonPhoneNumber->setNum2($data["phone_number"]["line"]);
		
		if(!$PersonPhoneNumber->getId()){
		    /* @var $Person \Entities\Person */
		    $Person = $this->_em->find("Entities\Person", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add address. No Person with that Id");

		    $Person->addPersonPhoneNumber($PersonPhoneNumber);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($PersonPhoneNumber);

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
	$this->view->PersonPhoneNumber  = $PersonPhoneNumber;
    }
}

