<?php
class Company_EmployeesTimeClocksController extends Dataservice_Controller_Action
{    
    public function viewStatusAction()
    {
	$this->view->Employees = $this->_Website->getCompany()->getEmployees();
    }
    
    public function viewTimeAction()
    {
	$this->view->Employees = $this->_Website->getCompany()->getEmployees();
    }
}

