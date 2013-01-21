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
	$EmailAddress	= $this->getEntityFromParamFields("Person\EmailAddress", array("id"));
	$form		= new Forms\Person\EmailAddress(array("method" => "post"), $EmailAddress);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["person_emailaddress"];
		
		$EmailAddress->populate($data);
		
		if(!$EmailAddress->getId())
		{
		    /* @var $Employee \Entities\Company\Employee */
		    $Employee = $this->_em->find("Entities\Company\Employee", $this->_params["employee_id"]);
		    
		    if(!$Employee)
			throw new Exception("Can not add email address. No Employee with that Id");

		    $Employee->addEmailAddress($EmailAddress);
		    $this->_em->persist($Employee);
		}
		else $this->_em->persist($EmailAddress);

		$this->_em->flush();

		$message = "Employee Email Address saved";
		
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
	$this->view->EmailAddress   = $EmailAddress;
    }
}

