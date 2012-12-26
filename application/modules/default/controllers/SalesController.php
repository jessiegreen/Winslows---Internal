<?php

/**
 * 
 * @author jessie
 *
 */

class SalesController extends Zend_Controller_Action
{
    protected $_Request;
    protected $_params;
    
    public function init(){
	$this->getRequest()	    = $this->getRequest();
	$this->_params	    = $this->getRequest()->getParams();
    }
    
    public function indexAction()
    {	

    }

    public function inventoryAction(){
	
    }
    
    public function testAction(){
	
    }

}

