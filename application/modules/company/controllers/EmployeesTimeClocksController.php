<?php
class Company_EmployeesTimeClocksController extends Dataservice_Controller_Action
{    
    public function viewStatusAction()
    {
	$this->view->Employees = $this->_Website->getCompany()->getEmployees();
    }
    
    public function viewTimeAction()
    {
	$this->view->Employees	= $this->_Website->getCompany()->getEmployees();
	$start_date		= $this->_getParam("start_date", "last Saturday");	
	$DateTime		= new \DateTime();
	$this->view->StartDate	= $DateTime->createFromFormat("U", strtotime($start_date));
    }
}

