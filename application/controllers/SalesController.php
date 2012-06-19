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

    
    
    public function testAction(){
	/* @var $em \Doctrine\ORM\EntityManager */
	$em	    = $this->_helper->EntityManager();
	/* @var $employee \Entities\Employee */
	$employee   = $em->getRepository('Entities\Webaccount')->findOneByUsername("multiple")->getPerson();
	$this->view->employee = $employee->getTitle();
    }

}

