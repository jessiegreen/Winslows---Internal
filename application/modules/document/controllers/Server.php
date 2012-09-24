<?php
/**
 * Description of Controller
 * 
 * @author Jessie
 */

class Document_ServerController extends Dataservice_Controller_Action
{
    public function init()
    {
	parent::init();
	$this->_helper->layout->disableLayout();
	
//	$ACL = new Dataservice_Controller_Plugin_ACL();
//	
//	$ACL->preDispatch($this->_request);
    }
    
    public function displayAction()
    {
	
    }
}