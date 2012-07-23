<?php

/**
 * This custom action helper just cuts down on the lengthy bit of typing we'd otherwise have
 * to do in order to retrieve the custom Entity Manager resource located in:
 * /library/Dataservice/Resource/Entitymanager.php 
 * 
 */
class Dataservice_Controller_Action_Helper_FlashMessenger extends Zend_Controller_Action_Helper_FlashMessenger
{
    public function direct()
    {
	
    }
    
    public function addSuccessMessage($message){
	$this->addMessage(array('message' => $message, 'status' => 'success'));
    }
    
    public function addErrorMessage($message){
	$this->addMessage(array('message' => $message, 'status' => 'error'));
    }
}

?>


