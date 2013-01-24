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
	/* @var $EmailAddress \Entities\Company\Employee\EmailAddress */
	$EmailAddress	= $this->getEntityFromParamFields("Company\Employee\EmailAddress", array("id"));
	$employee_id	= $this->_getParam("employee_id");
	
	if($employee_id)
	{
	    $Employee = $this->_em->find("Entities\Company\Employee", $employee_id);
		    
	    if(!$Employee)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get employee Id.");
		$this->_History->goBack();
	    }
	    
	    $EmailAddress->setEmployee($Employee);
	}
	
	$form = new Forms\Company\Employee\EmailAddress($EmailAddress, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_employee_email_address"];
		
		$EmailAddress->populate($data);
		
		$Employee = $this->_em->find("Entities\Company\Employee", $data["employee_id"]);
		    
		if(!$Employee)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add address. No Employee with that Id");
		    $this->_History->goBack();
		}

		$EmailAddress->setEmployee($Employee);
		
		$this->_em->persist($EmailAddress);

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

