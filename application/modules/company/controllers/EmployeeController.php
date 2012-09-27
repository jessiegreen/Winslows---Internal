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
	    $this->_redirect('/employee/viewall');
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
	$company_id = $this->_request->getParam("company_id", null);
	
	if(!$Employee->getId())
	{
	    if($company_id)
	    {
		$Company = $this->_em->getRepository("Entities\Company")->findOneById($company_id);
	    
		if($Company)
		{
		    $Employee->setCompany($Company);
		}
	    }
	}	
	
	$form	    = new Forms\Company\Employee(array("method" => "post"), $Employee);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$employee_data	= $this->_params["company_employee"];
		$Location	= $this->_em->find("Entities\Company\Location",$employee_data["location_id"]);
		$Company	= $this->_em->find("Entities\Company",$employee_data["company_id"]);

		if($Location)
		    $Employee->setLocation($Location);
		else throw new Exception("Can not edit employee. No Location with that Id");
		
		if($Company)
		    $Employee->setCompany($Company);
		else throw new Exception("Can not edit employee. No Company with that Id");


		$Employee->populate($employee_data);
		$this->_em->persist($Employee);
		$this->_em->flush();

		$message = "Employee '".htmlspecialchars($Employee->getFullName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_redirect('/employee/view/id/'.$Employee->getId());
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_redirect('/employee/viewall/');
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
    
    public function manageRolesAction()
    {
	$this->view->headScript()->appendFile("/javascript/company/employee/manage-roles.js");
	
	$Employee = $this->_getEmployee();
	
	$this->_CheckRequiredEmployeeExists($Employee);
	
	$this->view->Employee	= $Employee;
	$this->view->form		= new Forms\Company\Employee\ManageRoles($Employee);
    }
    
    public function addRoleAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	try{
	    $Employee   = $this->_getEmployee();
	    $Role	= $this->_getRole();

	    $this->_CheckRequiredEmployeeExists($Employee);
	    $this->_CheckRequiredRoleExists($Role);

	    $Employee->addRole($Role);
	    $this->_em->persist($Employee);
	    $this->_em->flush();
	    $this->_FlashMessenger->addSuccessMessage("Role Added");
	    $this->_History->goBack(1);
	} 
	catch (Exception $exc)
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    $this->_History->goBack(1);
	}
    }
    
    public function removeRoleAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	try
	{
	    $Employee   = $this->_getEmployee();
	    $Role	= $this->_getRole();

	    $this->_CheckRequiredEmployeeExists($Employee);
	    $this->_CheckRequiredRoleExists($Role);

	    $Employee->removeRole($Role);
	    $this->_em->persist($Employee);
	    $this->_em->flush();

	    $this->_FlashMessenger->addSuccessMessage("Role Removed");
	    $this->_History->goBack(1);
	} 
	catch (Exception $exc)
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    $this->_History->goBack(1);
	}
    }
    
    /**
     * @return Entities\Company\Employee
     */
    private function _getEmployee()
    {
	return $this->getEntityFromParamFields("Company\Employee", array("id"));
    }
    
    private function _CheckRequiredEmployeeExists(Entities\Company\Employee $Employee)
    {
	if(!$Employee->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Employee");
	    $this->_History->goBack();
	}
    } 
    
    /**
     * @return \Entities\Company\Employee\Role
     */
    private function _getRole()
    {
	$id = $this->_request->getParam("role_id", 0);
	return $this->_em->find("Entities\Company\Employee\Role", $id);
    }
    
    private function _CheckRequiredRoleExists(\Entities\Company\Employee\Role $Role)
    {
	if(!$Role->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Role");
	    $this->_History->goBack();
	}
    }
}

