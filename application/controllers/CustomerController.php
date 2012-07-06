<?php

/**
 * 
 * @author jessie
 *
 */

class CustomerController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function searchAction()
    {	
	$this->view->headScript()->appendFile("/javascript/customer/customer.js");
		$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
    }
    
    public function searchautocompleteAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->setLayout("blank");
	
	$term = $this->_autocompleteGetTerm();
	echo $term;
    }

    private function _autocompleteGetTerm(){
	$term = '';
	if (isset($_GET['term'])) {
	    $term = strtolower($_GET['term']);
	}
	if (!$term) {
	    exit;
	}
	return $term;
    }
}

