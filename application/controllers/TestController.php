<?php

/**
 * 
 * @author jessie
 *
 */

class TestController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
	$this->view->headLink()->appendStylesheet('/css/test.css');
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
	$builder = new \Services\Codebuilder\Codebuilder;
	$price_array = $builder->getPriceFromCode("AAMCCPRAAB12AC41AD05AINO_AJNO_AETNAFWHAGTNAHTNALNO_AKNO_", "ne");
	echo "**".$price_array["price"]."**";
    }
    
    public function codetohtmlAction(){
	$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
	
	$code	    = "";	
	$state	    = "";
	
	if(isset($this->_params['state'])){
	    $state = $this->_params['state'];
	}
	
	if(isset($this->_params['code'])){
	    $code = $this->_params['code'];
	}
	
	$parser		    = \Services\Codebuilder\Factory::factoryParser();
	$validator	    = \Services\Codebuilder\Factory::factoryValidator();
	$pricing	    = \Services\Codebuilder\Factory::factoryPricing();
	$BuilderArrayMapper    = \Services\Codebuilder\Factory::factoryBuilderArrayMapper();
	$errors	    = array();
	$warnings   = array();
	$price	    = 0;
	
	try {
	    $options	= $parser->parseToArray($code);
	    $validator->validateArray($BuilderArrayMapper, $options, $state);
	    $warnings	= $validator->getWarnings();
	    $errors	= $validator->getErrors();
	    if(count($errors)<1)$price	= $pricing->price($BuilderArrayMapper, $options);
	} catch (Exception $exc) {
	    $errors[] = $exc->getMessage();
	}
	echo "<h4 style='background-color:red'>".implode("<br />", $errors)."</h4>";
	echo "<h4 style='background-color:yellow'>".implode("<br />", $warnings)."</h4>";
	if(!$errors){
	    echo "$".$price;
	    echo "<h3>".$code."</h3>";

//	    foreach($options as $option_code => $option_array)
//	    {
//		foreach($option_array as $option)
//		{
//		    echo "<h3>".$option['details']['name']."</h3>";
//		    echo "<ol>";
//		    foreach ($option['values'] as $value) {
//			echo "<li>".$value['details']['name'].": ".$value['value_option']['name']."</li>";
//		    }
//		    echo "</ol>";
//		}
//	    }
	}
//	
//	echo "<pre>";
//	print_r($options);
//	echo "</pre>";
    }

    public function testinsertAction(){
	/* @var $em \Doctrine\ORM\EntityManager */
//	$em		    = $this->_helper->EntityManager();
//	/* @var $value \Entities\CbValue */
//	$value		    = $em->getRepository("\Entities\CbValue")->findOneById(56);
//
//	if($value){
//	foreach(range(1, 40) as $inches){
//	    $valueoption = new Entities\CbValueOption;
//	    $valueoption->setName($inches);
//	    $valueoption->setCode(str_pad($inches, 2, "0", STR_PAD_LEFT));
//	    $valueoption->setDescription("");
//	    $value->AddValueOption($valueoption);
//	    $em->persist($value);
//	}	
//	
//	    $em->flush();
//	}
//	exit;
    }

}

