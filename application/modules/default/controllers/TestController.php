<?php

/**
 * 
 * @author jessie
 *
 */

class TestController extends Zend_Controller_Action
{
    protected $_Request;
    protected $_params;
    
    public function init(){
	$this->getRequest()	    = $this->getRequest();
	$this->_params	    = $this->getRequest()->getParams();
	$this->view->headLink()->appendStylesheet('/css/test.css');
    }

    public function indexAction()
    {	
	$test = array("1", "0", "2", "3");
    }

}

