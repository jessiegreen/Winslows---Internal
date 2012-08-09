<?php

/**
 * 
 * @author jessie
 *
 */

class LogisticsController extends Zend_Controller_Action
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

    public function manageAction(){
	
    }
}

