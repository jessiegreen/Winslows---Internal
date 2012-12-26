<?php

/**
 * 
 * @author jessie
 *
 */

class IndexController extends Zend_Controller_Action
{
    public function init() {
	$session		= new Zend_Session_Namespace('Dataservice');
	$session->redirect	= $_SERVER['REQUEST_URI'];

	$this->getRequest()	    = $this->getRequest();
	$this->_params	    = $this->getRequest()->getParams();
    }
    
    public function indexAction()
    {
      
    }

}

