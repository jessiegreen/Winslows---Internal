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

    }

    public function inventoryAction(){
	
    }
    
    public function testAction(){
	
    }

}

