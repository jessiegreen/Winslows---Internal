<?php

/**
 * 
 * @author jessie
 *
 */

class Person_AddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PersonAddress \Entities\PersonAddress */
	$PersonAddress	= $this->getEntityFromParamFields("PersonAddress", array("id"));
	$form		= new Form_PersonAddress(array("method" => "post"), $PersonAddress);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["personaddress"];
		
		$PersonAddress->populate($data);
		
		if(!$PersonAddress->getId()){
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add address. No Person with that Id");

		    $Person->addPersonAddress($PersonAddress);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($PersonAddress);

		$this->_em->flush();

		$message = "Person Address saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form	    = $form;
	$this->view->PersonAddress  = $PersonAddress;
    }
}

