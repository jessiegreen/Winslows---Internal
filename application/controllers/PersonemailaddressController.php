<?php

/**
 * 
 * @author jessie
 *
 */

class PersonemailaddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PersonEmailAddress \Entities\PersonEmailAddress */
	$PersonEmailAddress = $this->getEntityFromParamFields("PersonEmailAddress", array("id"));
	$form		    = new Form_PersonEmailAddress(array("method" => "post"), $PersonEmailAddress);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["personemailaddress"];
		
		$PersonEmailAddress->populate($data);
		
		if(!$PersonEmailAddress->getId()){
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add email address. No Person with that Id");

		    $Person->addPersonEmailAddress($PersonEmailAddress);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($PersonEmailAddress);

		$this->_em->flush();

		$message = "Person Email Address saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form		= $form;
	$this->view->PersonEmailAddress = $PersonEmailAddress;
    }
}

