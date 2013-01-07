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
	$Employee = $this->_getEmployee();
	
	$this->_CheckRequiredEmployeeExists($Employee);
	
	$this->view->Employee	= $Employee;
    }
    
    public function viewallAction()
    {
	$EmployeeRepos		= $this->_em->getRepository("Entities\Company\Employee");
	$this->view->Employees	= $EmployeeRepos->findAll();
    }
    
    public function editAction()
    {
	$Employee   = $this->_getEmployee();
	$company_id = $this->getRequest()->getParam("company_id", null);
	
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
    
    public function clockPunchAction()
    {
	$Employee = $this->_getEmployee();
	
	$this->_CheckRequiredEmployeeExists($Employee);
	
	try
	{
	    $Employee->clockInOut();
	} 
	catch (Exception $exc)
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    $this->_History->goBack();
	}
	
	$this->_FlashMessenger->addSuccessMessage($Employee->isClockedIn() ? "Clocked In" : "Clocked Out");
	$this->_History->goBack();
	
	exit;
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
    
    public function getLeadsLabelValueJsonAction()
    {
	$param_all	    = $this->_getParam("all");
	$param_employee	    = $this->_getParam("employee");
	
	$all		= $param_all == 1 ? true : false;
	$Employee	= $param_employee ? 
			    $this->_Website->getCompany()->getEmployeeById($param_employee) : 
			    $this->_Website->getCurrentUserAccount(Zend_Auth::getInstance())->getPerson();
	/* @var $Leads \Doctrine\Common\Collections\ArrayCollection */
	$Leads		= $all ? $Employee->getAllAllowedLeads() : $Employee->getLeads();
	
	$return = array();

	foreach ($Leads as $Lead)
	{
	    $return[] = array("value" => $Lead->getId(), "label" => $Lead->getFullName());
	}
    
	echo $this->_helper->json($return);

	exit;
    }
    
    /**
     * @return \Entities\Company\Employee\Role
     */
    private function _getRole()
    {
	$id = $this->getRequest()->getParam("role_id", 0);
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

