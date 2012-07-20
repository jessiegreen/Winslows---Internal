<?php

/**
 * 
 * @author jessie
 *
 */

class EmployeeController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function addAction(){
	$form = new Form_Employee_Employee();
	if($this->_request->isPost()){
	    if($form->isValid($this->_params)){
		$data		= $this->_params;
		$Employee	= new Entities\Employee;
		
		$em		= $this->_helper->EntityManager();
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$Company	= \Services\Company::factory()->getCurrentCompany();
		$Locations	= $Company->getLocations();
		$Location	= $Locations[0];
		
		$Employee->setCompany($Company);
		$Employee->setLocation($Location);
		$Employee->setTitle($employee_data["title"]);
		$Employee->setFirstName($person_data["first_name"]);
		$Employee->setMiddleName($person_data["middle_name"]);
		$Employee->setLastName($person_data["last_name"]);
		$Employee->setSuffix($person_data["suffix"]);
		
		$em->persist($Employee);
		$em->flush();
		
		$message = "Employee '".htmlspecialchars($Employee->getFullName())."' saved";
		$flashMessenger->addMessage(array("message" => $message, "status" =>  "success"));
		$this->_redirect('/humanresources/employeeview/id/'.$Employee->getId());
	    }
	    else $form->populate ($this->_params);
	}
	$this->view->form = $form;
    }
    
    public function editAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	$this->view->headScript()->appendFile("/javascript/employee/employee.js");
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add address. No Id");
	    /* @var $Employee Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $this->_params["id"]);
	    
	    if(!$Employee)throw new Exception("Can not edit employee. No Employee with that Id");
	    
	    $form = new Form_Employee(array("method" => "post"), $Employee);
	    
	    if($this->_request->isPost()){
		if($form->isValid($this->_params)){
		    $data		= $this->_params;
		    $employee_data	= $data["employee"];
		    $Location		= $em->find("Entities\Location",$employee_data["location"]);
		    if(!$Location)throw new Exception("Can not edit employee. No Location with that Id");
		    
		    $Employee->populate($employee_data);
		    $Employee->setLocation($Location);

		    $em->persist($Employee);
		    $em->flush();

		    $message = "Employee '".htmlspecialchars($Employee->getFullName())."' saved";
		    $flashMessenger->addMessage(array("message" => $message, "status" =>  "success"));
		    $this->_redirect('/humanresources/employeeview/id/'.$Employee->getId());
		}
		else $form->populate ($this->_params);
	    }
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/humanresources/employeeview/id/'.$this->_params["id"]);
	}
	$this->view->form = $form;
    }
       
    public function addaddressAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add address. No Id");
	    /* @var $Employee Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $this->_params["id"]);
	    
	    if(!$Employee)throw new Exception("Can not add address. No Employee with that Id");
	    
	    $form = new Form_PersonAddress_PersonAddress(array("method" => "post"));
	    
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
		    $address_params = $this->_params["address"];
		    $PersonAddress = new \Entities\PersonAddress();
		    $PersonAddress->setName($address_params['name']);
		    $PersonAddress->setAddress1($address_params['address_1']);
		    $PersonAddress->setAddress2($address_params['address_2']);
		    $PersonAddress->setCounty($address_params['county']);
		    $PersonAddress->setCity($address_params['city']);
		    $PersonAddress->setState($address_params['state']);
		    $PersonAddress->setZip1($address_params['zip_1']);
		    $PersonAddress->setZip2($address_params['zip_2']);
		    $Employee->addPersonAddress($PersonAddress);
		    
		    $em->persist($Employee);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Employee Address '".$PersonAddress->getName()."' for '".
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
    
    public function editaddressAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["customer_id"]))throw new Exception("Can not edit address. No Id");
	    /* @var $Customer Entities\Customer */
	    $Customer	    = $em->find("Entities\Customer", $this->_params["customer_id"]);
	    $PersonAddress  = $em->find("Entities\Personaddress", $this->_params["address_id"]);
	    
	    if(!$Customer || !$PersonAddress)throw new Exception("Can not edit address. No Customer or Address with that Id");
	    
	    $form = new Form_PersonAddress_PersonAddress(array("method" => "post"), $PersonAddress);
	    
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
		    $address_params = $this->_params["address"];
		    $PersonAddress->setName($address_params['name']);
		    $PersonAddress->setAddress1($address_params['address_1']);
		    $PersonAddress->setAddress2($address_params['address_2']);
		    $PersonAddress->setCity($address_params['city']);
		    $PersonAddress->setState($address_params['state']);
		    $PersonAddress->setZip1($address_params['zip_1']);
		    $PersonAddress->setZip2($address_params['zip_2']);
		    
		    $em->persist($PersonAddress);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Address '".$PersonAddress->getName()."' for '".
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

