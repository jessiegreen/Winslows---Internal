<?php

/**
 * 
 * @author jessie
 *
 */

class EmployeeController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/employee/employee.js");
	parent::init();
    }
    
    public function viewAction()
    {
	$Employee = $this->getEntityFromParamFields("Employee", array("id"));
	
	if(!$Employee->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get Employee");
	    $this->_redirect('/employee/viewall');
	}
	
	$Company		= \Services\Company::factory()->getCurrentCompany();
	$this->view->Employee	= $Employee;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function viewallAction()
    {
	$EmployeeRepos		= $this->_em->getRepository("Entities\Employee");
	$this->view->Employees	= $EmployeeRepos->findAll();
    }
    
    public function editAction()
    {
	$Employee = $this->getEntityFromParamFields("Employee", array("id"));
	
	$form = new Form_Employee(array("method" => "post"), $Employee);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$employee_data	= $this->_params["employee"];

		if(!$Employee->getId()){
		    $Location		= $this->_em->find("Entities\Location",$employee_data["location"]);
		    if(!$Location)
			throw new Exception("Can not edit employee. No Location with that Id");

		    $Employee->setLocation($Location);
		}

		$Employee->populate($employee_data);
		$this->_em->persist($Employee);
		$this->_em->flush();

		$message = "Employee '".htmlspecialchars($Employee->getFullName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_redirect('/employee/view/id/'.$Employee->getId());
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_redirect('/employee/viewall/');
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
    
    public function addphoneAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add phone number. No Id");
	    /* @var $Employee Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $this->_params["id"]);
	    
	    if(!$Employee)throw new Exception("Can not add phone number. No Employee with that Id");
	    
	    $form = new Form_Person_PhoneNumber(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/humanresources/employeeview/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/humanresources/employeeview/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $phone_data = $this->_params["phonenumber"];
		    $PhoneNumber = new \Entities\PhoneNumber();
		    $PhoneNumber->setType($phone_data["type"]);
		    $PhoneNumber->setAreaCode($phone_data["phone_number"]["area"]);
		    $PhoneNumber->setNum1($phone_data["phone_number"]["prefix"]);
		    $PhoneNumber->setNum2($phone_data["phone_number"]["line"]);
		    $PhoneNumber->setExtension($phone_data["extension"]);
		    $Employee->addPhoneNumber($PhoneNumber);
		    
		    $em->persist($Employee);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Employee Phone Number '".$PhoneNumber->getType()."' for '".
						$Employee->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/humanresources/employeeview/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
    
    public function editphoneAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["customer_id"]))throw new Exception("Can not edit phone. No Id");
	    /* @var $Customer Entities\Customer */
	    $Customer	    = $em->find("Entities\Customer", $this->_params["customer_id"]);
	    $PhoneNumber    = $em->find("Entities\PhoneNumber", $this->_params["phonenumber_id"]);
	    
	    if(!$Customer || !$PhoneNumber)throw new Exception("Can not edit phone. No Customer or PhoneNumber with that Id");
	    
	    $form = new Form_Person_PhoneNumber(array("method" => "post"), $PhoneNumber);
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/customer/edit/id/".$this->_params["customer_id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/customer/edit/id/'.$this->_params["customer_id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $phone_data = $this->_params["phonenumber"];
		    
		    $PhoneNumber->setType($phone_data["type"]);
		    $PhoneNumber->setAreaCode($phone_data["phone_number"]["area"]);
		    $PhoneNumber->setNum1($phone_data["phone_number"]["prefix"]);
		    $PhoneNumber->setNum2($phone_data["phone_number"]["line"]);
		    $PhoneNumber->setExtension($phone_data["extension"]);
		    
		    $em->persist($PhoneNumber);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Phone Number '".$PhoneNumber->getType()."' for '".
						$Customer->getFullName()."' Edited", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/customer/edit/id/'.$this->_params["customer_id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
    
    public function editemailAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["customer_id"]))throw new Exception("Can not edit email. No Id");
	    /* @var $Customer Entities\Customer */
	    $Customer	    = $em->find("Entities\Customer", $this->_params["customer_id"]);
	    $EmailAddress   = $em->find("Entities\Emailaddress", $this->_params["emailaddress_id"]);
	    
	    if(!$Customer || !$EmailAddress)throw new Exception("Can not edit email. No Customer or Email with that Id");
	    
	    $form = new Form_Person_Emailaddress(array("method" => "post"), $EmailAddress);
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/customer/edit/id/".$this->_params["customer_id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/customer/edit/id/'.$this->_params["customer_id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $email_data = $this->_params["emailaddress"];
		    
		    $EmailAddress->setType($email_data["type"]);
		    $EmailAddress->setAddress($email_data["address"]);
		    
		    $em->persist($EmailAddress);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Email Address '".$EmailAddress->getType()."' for '".
						$Customer->getFullName()."' Edited", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/customer/edit/id/'.$this->_params["customer_id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
    
    public function addemailAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add email address. No Id");
	    /* @var $Employee Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $this->_params["id"]);
	    
	    if(!$Employee)throw new Exception("Can not add email address. No Employee with that Id");
	    
	    $form = new Form_Person_Emailaddress(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/humanresources/employeeview/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/humanresources/employeeview/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $email_data = $this->_params["emailaddress"];
		    $Emailaddress = new \Entities\Emailaddress();
		    $Emailaddress->setType($email_data["type"]);
		    $Emailaddress->setAddress($email_data["address"]);
		    $Employee->addEmailAddress($Emailaddress);
		    
		    $em->persist($Employee);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Employee Email Address '".$Emailaddress->getType()."' for '".
						$Employee->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/humanresources/employeeview/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
}

