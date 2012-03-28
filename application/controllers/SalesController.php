<?php

/**
 * 
 * @author jessie
 *
 */

class SalesController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function indexAction()
    {	
	#--Get Auth Instance
        $auth = Zend_Auth::getInstance();

	#--Check if user logged in
        if ($auth->hasIdentity()) {
	    /* @var $person \Entities\Person */
	    $person = $auth->getIdentity()->getPerson();
	    echo "Person:<br />";
	    echo $person->getFullName();
	}
	#--If not redirect to login
	else {
	    $this->_helper->redirector('index', 'login');
	    exit();
	}
    }

    public function addpersonAction(){
	$data = $this->_params;
	$form = new Form_EmployeeAddComplete();
	
	if($this->_request->isPost()){
	    if($form->isValid($data)){
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $em		    = $this->_helper->EntityManager();
		    $employee	    = new \Entities\Employee;
		    $personaddress  = new \Entities\PersonAddress;
		    $webaccount	    = new \Entities\Webaccount;

		    if(isset($data['webaccount']['username']))$webaccount->setUsername($data['webaccount']['username']);
		    if(isset($data['webaccount']['username']))$webaccount->setPassword ($data['webaccount']['password']);
		    
		    if(isset($data['employee']['title']))$employee->setTitle($data['employee']['title']);
		    if(isset($data['person']['first_name']))$employee->setFirstName($data['person']['first_name']);
		    if(isset($data['person']['middle_name']))$employee->setMiddleName($data['person']['middle_name']);
		    if(isset($data['person']['last_name']))$employee->setLastName($data['person']['last_name']);
		    if(isset($data['person']['suffix']))$employee->setSuffix ($data['person']['suffix']);

		    if(isset($data['address']['name']))$personaddress->setName($data['address']['name']);
		    if(isset($data['address']['address_1']))$personaddress->setAddress1($data['address']['address_1']);
		    if(isset($data['address']['address_2']))$personaddress->setAddress2($data['address']['address_2']);
		    if(isset($data['address']['city']))$personaddress->setCity($data['address']['city']);
		    if(isset($data['address']['state']))$personaddress->setState($data['address']['state']);
		    if(isset($data['address']['zip_1']))$personaddress->setZip1($data['address']['zip_1']);
		    if(isset($data['address']['zip_2']))$personaddress->setZip2($data['address']['zip_2']);

		    $employee->addPersonAddress($personaddress);
		    $employee->setWebaccount($webaccount);
		    $em->persist($employee);
		    $em->flush();

		    $flashMessenger->addMessage(array('message' => 'Employee Added', 'status' => 'success'));
		    $this->_redirect('/test');

		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		    $this->_redirect('/test');
		}
	    }
	    else{
		$form->populate($data);
	    }
	}
	$this->view->form = $form;	
    }
    
    public function testAction(){
	/* @var $em \Doctrine\ORM\EntityManager */
	$em	    = $this->_helper->EntityManager();
	/* @var $employee \Entities\Employee */
	$employee   = $em->getRepository('Entities\Webaccount')->findOneByUsername("multiple")->getPerson();
	$this->view->employee = $employee->getTitle();
    }

}

