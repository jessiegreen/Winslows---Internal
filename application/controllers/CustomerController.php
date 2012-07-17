<?php

/**
 * 
 * @author jessie
 *
 */

class CustomerController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function addAction(){
	$form = new Form_Customer_Add;
	if($this->_request->isPost()){
	    if($form->isValid($this->_params)){
		$data		= $this->_params;
		$Customer	= new Entities\Customer;
		$Address	= new Entities\PersonAddress();
		$Phonenumber	= new Entities\Phonenumber();
		$person_data	= $data["person"];
		$phone_data	= $data["phonenumber"];
		$address_data	= $data["address"];
		$customer_data	= $data["customer"];
		$em		= $this->_helper->EntityManager();
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		
		$Customer->setCompany($customer_data["company"]);
		$Customer->setFirstName($person_data["first_name"]);
		$Customer->setMiddleName($person_data["middle_name"]);
		$Customer->setLastName($person_data["last_name"]);
		$Customer->setSuffix($person_data["suffix"]);
		
		$Address->setName($address_data["name"]);
		$Address->setAddress1($address_data["address_1"]);
		$Address->setAddress2($address_data["address_2"]);
		$Address->setCity($address_data["city"]);
		$Address->setState($address_data["state"]);
		$Address->setZip1($address_data["zip_1"]);
		$Address->setZip2($address_data["zip_2"]);
		
		$Phonenumber->setType($phone_data["type"]);
		$Phonenumber->setAreaCode($phone_data["phone_number"]["area"]);
		$Phonenumber->setNum1($phone_data["phone_number"]["prefix"]);
		$Phonenumber->setNum2($phone_data["phone_number"]["line"]);
		$Phonenumber->setExtension($phone_data["extension"]);
		
		$Customer->addPersonAddress($Address);
		$Customer->addPhoneNumber($Phonenumber);
		
		$em->persist($Customer);
		$em->flush();
		
		$message = "Customer '".htmlspecialchars($Customer->getFullName())."' saved";
		$flashMessenger->addMessage(array("message" => $message, "status" =>  "success"));
		$this->_redirect('/customer/edit/id/'.$Customer->getId());
	    }
	    else $form->populate ($this->_params);
	}
	$this->view->form = $form;
    }
    
    public function editAction(){
	$this->view->headScript()->appendFile("/javascript/customer/customer.js");
	$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	$redirect	= false;
	
	if(isset($this->_params["id"])){
	    $Customer = $this->_helper->EntityManager()->find("Entities\Customer", $this->_params["id"]);
	    if(!$Customer)$redirect = true;
	}
	else $redirect = true;
	if($redirect){
	    $flashMessenger->addMessage(array("message" => "Could not get Customer", "status" =>  "error"));
	}
	
	$CompanyService		= new \Services\Company\Company();
	$Company		= $CompanyService->getCurrentCompany();
	$this->view->Customer	= $Customer;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function searchAction()
    {	
	$this->view->headScript()->appendFile("/javascript/customer/customer.js");
	$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
    }
    
    public function searchautocompleteAction()
    {
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$term		= $this->_autocompleteGetTerm();
	$LeadService	= new \Services\People\Lead();
	$return		= $LeadService->getAutocompleteLeadsArrayFromTerm($term, "customer");
	echo json_encode($return);
    }

    private function _autocompleteGetTerm(){
	$term = '';
	if (isset($_GET['term'])) {
	    $term = strtolower($_GET['term']);
	}
	if (!$term) {
	    exit;
	}
	return $term;
    }
    
    public function addaddressAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add address. No Id");
	    /* @var $Customer Entities\Customer */
	    $Customer	= $em->find("Entities\Customer", $this->_params["id"]);
	    
	    if(!$Customer)throw new Exception("Can not add address. No Customer with that Id");
	    
	    $form = new Form_PersonAddress_PersonAddress(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/customer/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/customer/edit/id/'.$this->_params["id"]);
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
		    $PersonAddress->setCity($address_params['city']);
		    $PersonAddress->setState($address_params['state']);
		    $PersonAddress->setZip1($address_params['zip_1']);
		    $PersonAddress->setZip2($address_params['zip_2']);
		    $Customer->addPersonAddress($PersonAddress);
		    
		    $em->persist($Customer);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Address '".$PersonAddress->getName()."' for '".
						$Customer->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/customer/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
    
    public function addphoneAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add phone number. No Id");
	    /* @var $Customer Entities\Customer */
	    $Customer	= $em->find("Entities\Customer", $this->_params["id"]);
	    
	    if(!$Customer)throw new Exception("Can not add phone number. No Customer with that Id");
	    
	    $form = new Form_Person_Phonenumber(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/customer/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/customer/edit/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $phone_data = $this->_params["phonenumber"];
		    $Phonenumber = new \Entities\Phonenumber();
		    $Phonenumber->setType($phone_data["type"]);
		    $Phonenumber->setAreaCode($phone_data["phone_number"]["area"]);
		    $Phonenumber->setNum1($phone_data["phone_number"]["prefix"]);
		    $Phonenumber->setNum2($phone_data["phone_number"]["line"]);
		    $Phonenumber->setExtension($phone_data["extension"]);
		    $Customer->addPhoneNumber($Phonenumber);
		    
		    $em->persist($Customer);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Phone Number '".$Phonenumber->getType()."' for '".
						$Customer->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/customer/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
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
	    $Phonenumber    = $em->find("Entities\Phonenumber", $this->_params["phonenumber_id"]);
	    
	    if(!$Customer || !$Phonenumber)throw new Exception("Can not edit phone. No Customer or Phonenumber with that Id");
	    
	    $form = new Form_Person_Phonenumber(array("method" => "post"), $Phonenumber);
	    
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
		    
		    $Phonenumber->setType($phone_data["type"]);
		    $Phonenumber->setAreaCode($phone_data["phone_number"]["area"]);
		    $Phonenumber->setNum1($phone_data["phone_number"]["prefix"]);
		    $Phonenumber->setNum2($phone_data["phone_number"]["line"]);
		    $Phonenumber->setExtension($phone_data["extension"]);
		    
		    $em->persist($Phonenumber);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Phone Number '".$Phonenumber->getType()."' for '".
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
	    /* @var $Customer Entities\Customer */
	    $Customer	= $em->find("Entities\Customer", $this->_params["id"]);
	    
	    if(!$Customer)throw new Exception("Can not add email address. No Customer with that Id");
	    
	    $form = new Form_Person_Emailaddress(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/customer/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/customer/edit/id/'.$this->_params["id"]);
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
		    $Customer->addEmailAddress($Emailaddress);
		    
		    $em->persist($Customer);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Email Address '".$Emailaddress->getType()."' for '".
						$Customer->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/customer/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
    
    public function editcontactAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["customer_id"]))throw new Exception("Can not edit contact. No Id");
	    /* @var $Customer Entities\Customer */
	    $Customer  = $em->find("Entities\Customer", $this->_params["customer_id"]);
	    /* @var $Customer Entities\Contact */
	    $Contact   = $em->find("Entities\Contact", $this->_params["contact_id"]);
	    
	    if(!$Customer || !$Contact)throw new Exception("Can not edit contact. No Customer or Contact with that Id");
	    
	    $form = new Form_Person_Contact(array("method" => "post"), $Contact);
	    
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
		    $contact_data = $this->_params["contact"];
		    
		    $Contact->setType($contact_data["type"]);
		    $Contact->setTypeDetail($contact_data["type_detail"]);
		    $Contact->setNote($contact_data["note"]);
		    $Contact->setResult($contact_data["result"]);
		    
		    $em->persist($Contact);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Customer Contact on '".
						$Contact->getCreated()->format("F j, Y, g:i a").
						"' for '".$Customer->getFullName()."' Edited", 
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
    
    public function addcontactAction(){
	$Auth		= new Services\Auth\Auth();
	$Person		= $Auth->getIdentityWebAccount()->getPerson();
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add contact. No Id");
	    /* @var $Customer \Entities\Customer */
	    $em->flush();
	    $Customer	= $em->find("Entities\Customer", $this->_params["id"]);
	    
	    if(!$Customer)throw new Exception("Can not add contact. No Customer with that Id");
	    
	    $Contact	    = new \Entities\Contact();
	    
	    if(isset($this->_params["type"]) && key_exists($this->_params["type"], $Contact->getTypeOptions())){
		$Contact->setType($this->_params["type"]);
		if(isset($this->_params["type_id"])){
		    switch ($this->_params["type"]) {
			case "phone":
			    $Phonenumber = $this->_helper->EntityManager()->find("Entities\Phonenumber", $this->_params["type_id"]);
			    if($Phonenumber)$Contact->setTypeDetail ($Phonenumber->getNumberDisplay());
			    break;
			case "location":
			    $Location = $this->_helper->EntityManager()->find("Entities\Location", $this->_params["type_id"]);
			    if($Location)$Contact->setTypeDetail ($Location->getName());
			    break;
			case "email":
			    $Email = $this->_helper->EntityManager()->find("Entities\Emailaddress", $this->_params["type_id"]);
			    if($Email)$Contact->setTypeDetail ($Email->getAddress());
			    break;
		    }
		}
	    }
	    
	    $form = new Form_Person_Contact(array("method" => "post"), $Contact);
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/customer/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/customer/edit/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $contact_data   = $this->_params["contact"];
		    $Contact	    = new \Entities\Contact();
		    
		    $Contact->setType($contact_data["type"]);
		    $Contact->setTypeDetail($contact_data["type_detail"]);
		    $Contact->setNote($contact_data["note"]);
		    $Contact->setResult($contact_data["result"]);
		    $Contact->setPerson($Person);
		    
		    $Customer->addContact($Contact);
		    
		    $em->persist($Customer);
		    $em->flush();
		    
		    $flashMessenger->addMessage(
			    array(
				'message' => "Contact '".
						$Contact->getCreated()->format("F j, Y, g:i a").
						"' added to '".$Contact->getLead()->getFullName()."'", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/customer/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
}

