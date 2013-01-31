<?php
class Company_EmployeePhoneNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $PhoneNumber \Entities\Company\Employee\PhoneNumber */
	$PhoneNumber	= $this->getEntityFromParamFields("Company\Employee\PhoneNumber", array("id"));
	$employee_id	= $this->_getParam("employee_id");
	
	if($employee_id)
	{
	    $Employee = $this->_em->find("Entities\Company\Employee", $employee_id);
		    
	    if(!$Employee)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get employee Id.");
		$this->_History->goBack();
	    }
	    
	    $PhoneNumber->setEmployee($Employee);
	}
		
	$form = new Forms\Company\Employee\PhoneNumber($PhoneNumber, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_employee_phone_number"];
		
		$PhoneNumber->populate($data);
		$PhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$PhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$PhoneNumber->setNum2($data["phone_number"]["line"]);
		
		$Employee = $this->_em->find("Entities\Company\Employee", $data["employee_id"]);
		    
		if(!$Employee)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add phone number. No Employee with that Id");
		    $this->_History->goBack();
		}

		$PhoneNumber->setEmployee($Employee);
		
		$this->_em->persist($PhoneNumber);

		$this->_em->flush();

		$message = "Employee Phone Number saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	  = $form;
	$this->view->PhoneNumber  = $PhoneNumber;
    }
}

