<?php
class Company_EmployeeFaxNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $FaxNumber \Entities\Company\Employee\FaxNumber */
	$FaxNumber	= $this->getEntityFromParamFields("Company\Employee\FaxNumber", array("id"));
	$employee_id	= $this->_getParam("employee_id");
	
	if($employee_id)
	{
	    $Employee = $this->_em->find("Entities\Company\Employee", $employee_id);
		    
	    if(!$Employee)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get employee Id.");
		$this->_History->goBack();
	    }
	    
	    $FaxNumber->setEmployee($Employee);
	}
		
	$form = new Forms\Company\Employee\FaxNumber($FaxNumber, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_employee_fax_number"];
		
		$FaxNumber->populate($data);
		$FaxNumber->setAreaCode($data["fax_number"]["area"]);
		$FaxNumber->setNum1($data["fax_number"]["prefix"]);
		$FaxNumber->setNum2($data["fax_number"]["line"]);
		
		$Employee = $this->_em->find("Entities\Company\Employee", $data["employee_id"]);
		    
		if(!$Employee)
		{
		    $this->_FlashMessenger->addErrorMessage("Can not add fax number. No Employee with that Id");
		    $this->_History->goBack();
		}

		$FaxNumber->setEmployee($Employee);
		
		$this->_em->persist($FaxNumber);

		$this->_em->flush();

		$message = "Employee Fax Number saved";
		
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
	$this->view->FaxNumber  = $FaxNumber;
    }
}

