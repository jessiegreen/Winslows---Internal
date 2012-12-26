<?php

/**
 * 
 * @author jessie
 *
 */

class HumanresourcesController extends Zend_Controller_Action
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
}

