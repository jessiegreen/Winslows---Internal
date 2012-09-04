<?php

/**
 * 
 * @author jessie
 *
 */

class Company_EmployeeController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/employee.js");
	parent::init();
    }
    
    public function viewAction()
    {
	$Employee = $this->getEntityFromParamFields("Company\Employee", array("id"));
	
	if(!$Employee->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Employee");
	    $this->_redirect('/company/employee/viewall');
	}
	
	$Company		= \Services\Company::factory()->getCurrentCompany();
	$this->view->Employee	= $Employee;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function viewallAction()
    {
	$EmployeeRepos		= $this->_em->getRepository("Entities\Company\Employee");
	$this->view->Employees	= $EmployeeRepos->findAll();
    }
    
    public function editAction()
    {
	$Employee   = $this->getEntityFromParamFields("Company\Employee", array("id"));
	$form	    = new Forms\Company\Employee(array("method" => "post"), $Employee);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$employee_data	= $this->_params["company_employee"];
		$Location	= $this->_em->find("Entities\Company\Location",$employee_data["location"]);

		if(!$Location)
		    throw new Exception("Can not edit employee. No Location with that Id");

		$Employee->setLocation($Location);

		$Employee->populate($employee_data);
		$this->_em->persist($Employee);
		$this->_em->flush();

		$message = "Employee '".htmlspecialchars($Employee->getFullName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_redirect('/company/employee/view/id/'.$Employee->getId());
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_redirect('/company/employee/viewall/');
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
}

