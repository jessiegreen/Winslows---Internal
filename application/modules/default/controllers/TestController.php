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
	$test = array("1", "0", "2", "3");
    }

}

