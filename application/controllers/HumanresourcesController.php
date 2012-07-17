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
	$this->view->headScript()->appendFile("/javascript/maintenance/employee/employee.js");
	
	$em			= $this->_helper->EntityManager();
	$EmployeeRepos		= $em->getRepository("Entities\Employee");
	$this->view->Employees	= $EmployeeRepos->findAll();
    }
    
    public function employeeviewAction(){
	
    }
}

