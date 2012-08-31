<?php

/**
 * 
 * @author jessie
 *
 */

class CodebuilderController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init()
    {
	$session		= new Zend_Session_Namespace('Dataservice');
	$session->redirect	= $_SERVER['REQUEST_URI'];

	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function indexAction()
    {
	
    }
    
    public function optionsviewAction()
    {
	$this->view->headScript()->appendFile("/javascript/codebuilder/option/option.js");
	$em			= $this->_helper->EntityManager();
	$this->view->options	= $em->getRepository('Entities\CbOption')->findAll();
    }
    
    
    public function optioneditAction()
    {
	$id	= isset($this->_params['id']) ? $this->_params['id'] : null;
	$em	= $this->_helper->EntityManager();
	$Option	= $id ? $em->getRepository('\Entities\CbOption')->findOneById($id) : null;
	$form	=  new Form_Codebuilder_Option(array("method" => "post"), $Option);
	
	$form->addElement("button", "cancel", array("label" => "cancel", "onclick" => "location='/codebuilder/optionsview'"));
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $new = false;
		    if(!$Option){
			$Option	= new \Entities\CbOption; 
			$new	= true;
		    }
		    $em = $this->_helper->EntityManager();
		    $Option->setName($this->_params['option']['name']);
		    $Option->setCode($this->_params['option']['code']);
		    $Option->setDescription($this->_params['option']['description']);
		    $em->persist($Option);
		    $em->flush();
		    $flashMessenger->addMessage(array('message' => "Option '".$Option->getName()."' ".($new ? "Added" : "Edited"), 'status' => 'success'));
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/codebuilder/optionsview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form = $form;
    }
    
    public function valueeditAction()
    {
	$option_id	= isset($this->_params['option_id']) ? $this->_params['option_id'] : null;
	$value_id	= isset($this->_params['value_id']) ? $this->_params['value_id'] : null;
	$em		= $this->_helper->EntityManager();
	$new		= false;
	
	if($option_id) {
	    /* @var $Value \Entities\CbValue */
	    $Value	= new \Entities\CbValue;
	    /* @var $Option \Entities\CbOption */
	    $Option	= $em->getRepository('\Entities\CbOption')->findOneById($option_id);
	    $new	= true;
	}
	elseif($value_id) $Value = $em->getRepository('\Entities\CbValue')->findOneById($value_id);
	else $this->_redirect('/codebuilder/optionsview');
	
	$form	=  new Form_Codebuilder_Value(array("method" => "post"), $Value);
	
	$form->addElement("button", "cancel", array("label" => "cancel", "onclick" => "location='/codebuilder/optionsview'"));
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $em = $this->_helper->EntityManager();
		    $Value->setName($this->_params['value']['name']);
		    $Value->setLength($this->_params['value']['length']);
		    $Value->setDescription($this->_params['value']['description']);
		    if(!$Value->getOption()){
			$Option->addValue($Value);
			$em->persist($Option);
		    }
		    else $em->persist($Value);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Value '".$Value->getName()."' ".
					    (
						$new ? "Added to ".$Option->getCode()."-".$Option->getName() 
						: "Edited"), 'status' => 'success')
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/codebuilder/optionsview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->option_name = isset($Option) ? $Option->getName() : null;
    }
    
    public function valueoptioneditAction()
    {
	$valueoption_id	= isset($this->_params['valueoption_id']) ? $this->_params['valueoption_id'] : null;
	$value_id	= isset($this->_params['value_id']) ? $this->_params['value_id'] : null;
	$em		= $this->_helper->EntityManager();
	$new		= false;
	
	if($value_id) {
	    /* @var $Value \Entities\CbValue */
	    $Valueoption = new \Entities\CbValueOption;
	    /* @var $Option \Entities\CbOption */
	    $Value	= $em->getRepository('\Entities\CbValue')->findOneById($value_id);
	    $new	= true;
	}
	elseif($valueoption_id) $Valueoption = $em->getRepository('\Entities\CbValueOption')->findOneById($valueoption_id);
	else $this->_redirect('/codebuilder/optionsview');
	
	$form	=  new Form_Codebuilder_ValueOption(array("method" => "post"), $Valueoption);
	
	$form->addElement("button", "cancel", array("label" => "cancel", "onclick" => "location='/codebuilder/optionsview'"));
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $em = $this->_helper->EntityManager();
		    $Valueoption->setName($this->_params['valueoption']['name']);
		    $Valueoption->setIndex($this->_params['valueoption']['index']);
		    $Valueoption->setCode($this->_params['valueoption']['code']);
		    $Valueoption->setDescription($this->_params['valueoption']['description']);
		    if(!$Valueoption->getValue()){
			$Value->AddValueOption($Valueoption);
			$em->persist($Value);
		    }
		    else $em->persist($Valueoption);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Value '".$Valueoption->getName()."' ".
					    (
						$new ? "Added to ".$Value->getName() 
						: "Edited"), 'status' => 'success')
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/codebuilder/optionsview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->value_name = isset($Value) ? $Value->getName() : null;
    }
    
    public function groupviewAction()
    {
	if(isset($this->_params['id'])){
	    $option_id	= $this->_params['id'];
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $employee \Entities\Company\Employee */
	    $employee   = $em->getRepository('Entities\Group')->findOneById($option_id);
	    
	    if(!$employee){
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$flashMessenger->addMessage(array('message' => "Could not find Group.", 'status' => 'error'));
		$this->_redirect('/maintenance/values');
	    }
	}
    }
    
    public function valuedeleteAction()
    {
	$id	= isset($this->_params['value_id']) ? $this->_params['value_id'] : null;
	$em	= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	try {
	    $Value = $em->getRepository('\Entities\CbValue')->findOneById($id);
	    $em = $this->_helper->EntityManager();
	    if($Value){
		$em->remove($Value);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Deleted value '".$Value->getName()."'", 'status' => 'success'));
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "value Does Not Exist.", 'status' => 'error'));
	    }
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	}
	$this->_redirect('/codebuilder/optionsview');
    }
    
    public function valueoptiondeleteAction()
    {
	$id	= isset($this->_params['valueoption_id']) ? $this->_params['valueoption_id'] : null;
	$em	= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	try {
	    $Valueoption = $em->getRepository('\Entities\CbValueOption')->findOneById($id);
	    $em = $this->_helper->EntityManager();
	    if($Valueoption){
		$em->remove($Valueoption);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Deleted value '".$Valueoption->getName()."'", 'status' => 'success'));
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Value Option Does Not Exist.", 'status' => 'error'));
	    }
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	}
	$this->_redirect('/codebuilder/optionsview');
    }
}

