<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_Webaccount_Webaccount extends Zend_Form{
    public function init($options = array()){
	$this->addElement('text', 'username', array(
            'required'	    => true,
            'label'	    => 'Username:',
	    'belongsTo'	    => 'webaccount'
        ));
	
	$this->addElement('password', 'password', array(
            'required'	    => true,
            'label'	    => 'Password:',
	    'belongsTo'	    => 'webaccount'
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
