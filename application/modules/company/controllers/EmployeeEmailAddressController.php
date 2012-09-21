<?php

/**
 * 
 * @author jessie
 *
 */

class Company_EmployeeEmailAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $EmailAddress \Entities\Person\EmailAddress */
	$EmailAddress = $this->getEntityFromParamFields("Person\EmailAddress", array("id"));
	$form		    = new Forms\Person\EmailAddress(array("method" => "post"), $EmailAddress);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["person_emailaddress"];
		
		$EmailAddress->populate($data);
		
		if(!$EmailAddress->getId())
		{
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    
		    if(!$Person)
			throw new Exception("Can not add email address. No Person with that Id");

		    $Person->addEmailAddress($EmailAddress);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($EmailAddress);

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
	$this->view->EmailAddress = $EmailAddress;
    }
}

