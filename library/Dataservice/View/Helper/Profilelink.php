<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Dataservice_View_Helper_Profilelink//  extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function profilelink()
    {
        $auth = Zend_Auth::getInstance();
	
        if($auth->hasIdentity())
	{
	    $Account	    = \Services\Website::factory()->getCurrentWebsite()->getCurrentUserAccount($auth);
	    $return	    = '<span> Welcome, ' . $Account->getUsername().'</span>';
	    $return	    .= ' <a href="/profile/index/id/' . $Account->getId().'">'.Dataservice\Html\Button::buttonIcon("user_edit.png", "person_account", "Account Settings").'</a> ';
	    $return	    .= '<a href="/login/logout">'.  Dataservice\Html\Button::buttonIcon("door_out.png", "logout", "Log Out").'</a>';
	    
	    return $return;
        }
    }
}