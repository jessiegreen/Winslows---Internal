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
	    $Person	    = \Services\Auth::factory()->getIdentityPerson();
	    $return	    = '<span> Welcome, ' . $Person->getFirstName()." ".$Person->getLastName().'</span>';
	    $return	    .= ' <a href="/profile/index/id/' . $Person->getId().'">'.HTML::buttonIcon("user_edit.png", "person_account", "Account Settings").'</a> ';
	    $return	    .= '<a href="/login/logout">'.HTML::buttonIcon("door_out.png", "logout", "Log Out").'</a>';
	    
	    return $return;
        }
    }
}