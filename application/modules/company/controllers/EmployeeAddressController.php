<?php

/**
 * 
 * @author jessie
 *
 */

class Company_EmployeeAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $Address \Entities\Company\Employee\Address */
	$Address	= $this->getEntityFromParamFields("Company\Employee\Address", array("id"));
	$employee_id	= $this->_getParam("employee_id");
	
	if($employee_id)
	{
	    $Employee = $this->_em->find("Entities\Company\Employee", $employee_id);
		    
	    if(!$Employee)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get employee Id.");
		$this->_History->goBack();
	    }
	    
	    $Address->setEmployee($Employee);
	}
	
	$form		= new \Forms\Company\Employee\Address($Address, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_employee_address"];
		
		$Address->populate($data);
		
		$Employee = $this->_em->find("Entities\Company\Employee", $data["employee_id"]);
		    
		if(!$Employee)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add address. No Employee with that Id");
		    $this->_History->goBack();
		}

		$Address->setEmployee($Employee);
		
		$this->_em->persist($Address);

		$this->_em->flush();

		$message = "Employee Address saved";
		
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
	$this->view->PersonAddress  = $Address;
    }
}

