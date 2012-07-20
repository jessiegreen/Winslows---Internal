<?php

/**
 * 
 * @author jessie
 *
 */

class HumanresourcesController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function indexAction()
    {	
	
    }

    public function employeesviewAction(){
	$this->view->headScript()->appendFile("/javascript/humanresources/employee/employee.js");
	
	$em			= $this->_helper->EntityManager();
	$EmployeeRepos		= $em->getRepository("Entities\Employee");
	$this->view->Employees	= $EmployeeRepos->findAll();
    }
    
    public function employeeviewAction(){
	$this->view->headScript()->appendFile("/javascript/humanresources/employee/employee.js");
	
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	$redirect	= false;
	
	if(isset($this->_params["id"])){
	    $Employee = $this->_helper->EntityManager()->find("Entities\Employee", $this->_params["id"]);
	    if(!$Employee)$redirect = true;
	}
	else $redirect = true;
	if($redirect){
	    $flashMessenger->addMessage(array("message" => "Could not get Employee", "status" =>  "error"));
	}
	
	$Company		= \Services\Company::factory()->getCurrentCompany();
	$this->view->Employee	= $Employee;
	$this->view->Locations	= $Company->getLocations();
    }
}

